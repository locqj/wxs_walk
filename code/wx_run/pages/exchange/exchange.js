Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
 
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    let that = this
     wx.getStorage({
      key: 'openid',
      success: function (res) {
        that.setData({
          openid: res.data,
        })
      }
    })
     wx.getStorage({
       key: 'userlog',
       success: function (res) {
         that.setData({
           userlog: res.data,
         })
       }
     })
     wx.getStorage({
       key: 'change_goods',
       success: function (res) {
         console.log(res.data)
         that.setData({
           change_goods: res.data,
         })
       }
     })

     console.log(this.data.change_goods)
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
  exchange: function(e) {
    let code = e.target.dataset.code
    console.log(code)
    wx.request({
      url: 'https://wx.locqj.top/client/getreward',
      data: {
        good_code: code,
        openid: openid
      },
      method: 'POST',
      success: function(res) {
        
      }
    })


  }
})