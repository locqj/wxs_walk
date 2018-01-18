// pages/editinfo/editinfo.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    userinfo: null,
    sexs: ['男', '女'],
    indexSex: 0,
    date: '1994-06-30',
    heights: [],
    weights: [],
    indexHeight: 175,
    indexWeight: 60
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let height = new Array(220);
    let weight = new Array(120);
    for (let i = 140; i < height.length; i++) {
      height[i] = i + 'CM';
    }
    console.log(height)

    for (let i = 30; i < weight.length; i++) {
      weight[i] = i + 'KG';
    }
    console.log(weight)
    this.setData({
      userinfo: app.globalData.userInfo,
      heights: height,
      weights: weight
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },
  bindAgeChange: function (e) {
    this.setData({
      indexSex: e.detail.value,
    })
  },
  bindDateChange: function (e) {
    this.setData({
      date: e.detail.value
    })
  },
  bindHeightChange: function (e) {
    this.setData({
      indexHeight: e.detail.value,
    })
  },
  bindWeightChange: function (e) {
    this.setData({
      indexWeight: e.detail.value,
    })
  },
})