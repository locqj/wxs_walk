//index.js
//获取应用实例
const app = getApp()
// 调用工具类
let util = require('../../utils/util.js')

Page({
  data: {
    userInfo: {},
    hasUserInfo: false,
    targetstep: 8000,
    userSteps: {},
    power_kcal: 0,
    sport_distance: 0,
    ground_distance: 0,
    rice_g: 0
  },
  //事件处理函数
  bindViewTap: function () {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onReady: function (e) {
  },
  onLoad: function () {
    
    let that = this
    wx.login({
      success: function (res) {
        let code = res.code
        that.setData({ code: code })
        wx.getWeRunData({//解密微信运动
          success(res) {
            const wRunEncryptedData = res.encryptedData
            that.setData({ 
              encryptedData: wRunEncryptedData,
              iv: res.iv,
              now_time: util.haveSomeMinutesTime()
            })
            that.get3rdSession()//解密请求函数
          }
        })
      },
      fail: function (res) { },
      complete: function (res) { },
    })

    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse) {
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
  },

  get3rdSession: function (callback) {
    let that = this
    wx.request({
      url: 'https://wx.locqj.top/api/getsessionkey',
      data: {
        code: this.data.code
      },
      method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
      success: function (res) {
        let rest = res.data.replace(" ", "");
        // json 字符串转json
        if (typeof rest != 'object') {
          rest = rest.replace(/\ufeff/g, "");//重点
          let jj = JSON.parse(rest);
          rest = jj;
        }
        // let sessionKey = res.data.replace(/\s+/g, "") //很重要去除空格 session_key标准24位
        that.setData({ sessionKey: rest.session_key, openid: rest.openid })
        that.decodeUserInfo(callback)
      }
    })
  },
  // 解析数据
  decodeUserInfo: function (callback) {
    let that = this
    // console.log(that.data.userInfo)
    wx.request({
      url: 'https://wx.locqj.top/api/decrypt',
      data: {
        encryptedData: that.data.encryptedData,
        iv: that.data.iv,
        session: that.data.sessionKey,
        nickname: that.data.userInfo.nickName,
        head_img: that.data.userInfo.avatarUrl,
        target_step: that.data.targetstep,
        openid: that.data.openid
      },
      method: 'POST',
      success: function (res) {
       
        let todayStep = res.data.replace(" ", "");
        // json 字符串转json
        if (typeof todayStep != 'object') {
          todayStep = todayStep.replace(/\ufeff/g, "");//重点
          let jj = JSON.parse(todayStep);
          todayStep = jj;
        }
        let now_step = todayStep.stepInfoList[30].step
        let power_kcal = now_step * 0.04 //消耗的大卡
        let sport_distance = now_step * 0.00055 //行走的里程
        let ground_distance = sport_distance / 200 //相当于几圈200米操场
        let rice_g = power_kcal * 1.16 //相当于消耗几克米饭
        // 保存用户近31天步数
        that.setData({
          userSteps: todayStep.stepInfoList,
          power_kcal: power_kcal.toFixed(1),
          sport_distance: sport_distance.toFixed(2),
          ground_distance: ground_distance.toFixed(1),
          rice_g: rice_g.toFixed(1),
          userlog: todayStep.userinfo,
          step_day: todayStep.step_day,
          step_month: todayStep.step_month,
        });
        // 储存基本信息
        wx.setStorage({ key: "openid", data: that.data.openid })
        wx.setStorage({ key: "userlog", data: that.data.userlog })
        wx.setStorage({ key: 'change_goods', data: todayStep.change_goods })
        console.log(todayStep)
        // 渲染canvas
        that.printCanvas()
      }
    })
  },
  printCanvas: function (e) {
    let that = this
    let query = wx.createSelectorQuery();
    query.select('#canvas-print').boundingClientRect()
    query.exec(function (res) {
      //res就是 所有标签为mjltest的元素的信息 的数组
      //取宽度
      let midwidth = res[0].width / 2
      let midheight = res[0].height / 2
      //创建并返回绘图上下文context对象。
      let ctx = wx.createCanvasContext('canvasCircle')
      let nowstep = that.data.userSteps[30].step
      let targetstep = 8000
      that.setData({
        targetstep: targetstep
      })
      let x = nowstep / targetstep //当前所走步数占目标步数的比
      if (nowstep > targetstep) {
        x = 1
      }
      let start = 1.5 * Math.PI
      let end = start + 2 * Math.PI * x
      ctx.setLineCap('round')
      ctx.setTextAlign('center')


      ctx.beginPath()
      ctx.setLineWidth(35)
      ctx.setStrokeStyle('#D4E8ED')
      ctx.arc(midwidth, midheight, midheight * 0.7, 0, 2 * Math.PI, false)
      ctx.stroke()


      ctx.beginPath()
      ctx.arc(midwidth, midheight, midheight * 0.62, 0, 2 * Math.PI)
      ctx.setFillStyle('#FFFFFF')
      ctx.fill()



      ctx.beginPath()
      ctx.setLineWidth(30)
      ctx.setStrokeStyle('#97E4E7')
      ctx.arc(midwidth, midheight, midheight * 0.72, start, end, false)
      ctx.stroke()

      ctx.beginPath()
      ctx.setFillStyle('#3E4858')
      ctx.setFontSize(38)
      ctx.fillText(nowstep, midwidth, midheight)

      ctx.beginPath()
      ctx.setFillStyle('#444444')
      ctx.setFontSize(10)
      ctx.fillText('当前步数', midwidth, midheight + 30)
      ctx.draw()
    })
  },
  getUserInfo: function (e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  },
  charts: function (e) {
    let step_day = JSON.stringify(this.data.step_day)
    let step_month = JSON.stringify(this.data.step_month)
    wx.navigateTo({
      url: '../charts/charts?step_day=' + step_day + '&step_month=' + step_month,
    })
  },
  target: function (e) {
    wx.navigateTo({
      url: '../targets/targets?openid=' + this.data.openid,
    })
  }

})
