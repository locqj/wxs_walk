//index.js
//获取应用实例
const app = getApp()
Page({
  data: {
    motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    targetstep: 0
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  }, 
  onReady: function (e) {
    let _this = this
    let query = wx.createSelectorQuery();
    query.select('#canvas-print').boundingClientRect()
    query.exec(function (res) {
      //res就是 所有标签为mjltest的元素的信息 的数组
      //取宽度
      let midwidth = res[0].width / 2
      let midheight = res[0].height / 2
      //创建并返回绘图上下文context对象。
      let ctx = wx.createCanvasContext('canvasCircle')
      let newstep = 7000
      let targetstep = 8000
      _this.setData({
        targetstep: targetstep
      })
      let x = newstep / targetstep //当前所走步数占目标步数的比
      if (newstep > targetstep) {
        x = 1
      }
      let start = 1.5 * Math.PI
      let end = start + 2 * Math.PI * x
      ctx.setLineCap('round')
      ctx.setTextAlign('center')


      ctx.beginPath()
      ctx.setLineWidth(35)
      ctx.setStrokeStyle('#D4E8ED')
      ctx.arc(midwidth, midheight, midheight * 0.78, 0, 2 * Math.PI, false)
      ctx.stroke()


      ctx.beginPath()
      ctx.arc(midwidth, midheight, midheight * 0.7, 0, 2 * Math.PI)
      ctx.setFillStyle('#FFFFFF')
      ctx.fill()



      ctx.beginPath()
      ctx.setLineWidth(30)
      ctx.setStrokeStyle('#97E4E7')
      ctx.arc(midwidth, midheight, midheight * 0.8, start, end, false)
      ctx.stroke()

      ctx.beginPath()
      ctx.setFillStyle('#3E4858')
      ctx.setFontSize(40)
      ctx.fillText(newstep, midwidth, midheight)

      ctx.beginPath()
      ctx.setFillStyle('#444444')
      ctx.setFontSize(13)
      ctx.fillText('当前步数', midwidth, midheight + 30)

      // ctx.beginPath()
      // ctx.setFillStyle('#444444')
      // ctx.setFontSize(13)
      // ctx.fillText('当日目标' + targetstep + '步，未完成', midwidth, midheight +150)

      ctx.draw()
    })

  },
  onLoad: function () {
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse){
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
  getRunData: function(e) {
    wx.getWeRunData({
      success(res) {
        console.log(res)
        const encryptedData = res.encryptedData
      }
    })
  },
  getUserInfo: function(e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  },
  charts: function(e) {
    wx.navigateTo({
      url: '../charts/charts',
    })
  },
  target: function(e) {
    wx.navigateTo({
      url: '../targets/targets',
    })  },

})