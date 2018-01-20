let sliderWidth = 96; // 需要设置slider的宽度，用于计算中间位置
const app = getApp()


Page({
  data: {
    tabs: ["未核销", "已核销"],
    activeIndex: 0,
    sliderOffset: 0,
    sliderLeft: 0,
    userinfo: null,
    item: [1, 2, 3, 4, 5],
    test_img: 'https://ss0.bdstatic.com/94oJfD_bAAcT8t7mm9GUKT-xh_/timg?image&quality=100&size=b4000_4000&sec=1516220076&di=39849a12778a7b3c703d345a47cb722e&src=http://imgsrc.baidu.com/imgad/pic/item/f2deb48f8c5494ee114d938427f5e0fe98257ec4.jpg'
  },

  onReady: function () {
    let that = this
    that.setData({ userinfo: app.globalData.userInfo })
    console.log(that.data.userinfo)
    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          sliderLeft: (res.windowWidth / that.data.tabs.length - sliderWidth) / 2,
          sliderOffset: res.windowWidth / that.data.tabs.length * that.data.activeIndex
        })
      }
    })
  },
  tabClick: function (e) {
    this.setData({
      sliderOffset: e.currentTarget.offsetLeft,
      activeIndex: e.currentTarget.id
    })
  },
  btnsub: function (e) {
    wx.navigateTo({
      url: '../qrcode/qrcode',
    })
  }
})