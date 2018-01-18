let sliderWidth = 96; // 需要设置slider的宽度，用于计算中间位置
const app = getApp()


Page({
  data: {
    tabs: ["今日排行", "本周排行"],
    activeIndex: 0,
    sliderOffset: 0,
    sliderLeft: 0,
    userinfo: null
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
        });
      }
    });
  },
  tabClick: function (e) {
    this.setData({
      sliderOffset: e.currentTarget.offsetLeft,
      activeIndex: e.currentTarget.id
    });
  }
});