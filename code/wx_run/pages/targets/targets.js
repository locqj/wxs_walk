Page({
  data: {
    imgUrls: [
      'http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175866434296.jpg',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'
    ],
    step: 8000
  },
  onLoad: function(option) {
    this.setData({
      openid: option.openid
    })
  },
  onchange: function(e) {
    let current = e.detail.current
    let step = 0
    if (current == 0) {
      step = 8000
    } else if (current == 1) {
      step = 16000
    } else if (current == 2) {
      step = 24000
    }
    this.setData({step: step})
  },
  onReady: function(e) {
    // console.log(this.data.target)
    // this.setData({step: 8000})
  },
  sub: function() {
    let that = this
    wx.showModal({
      title: '提示',
      content: '确定修改目标步数为'+that.data.step,
      success: function (res) {
        
        if (res.confirm) {
          wx.showLoading({
            title: '提交中',
            mask: true //防止页面穿透
          })
          wx.request({
            url: 'https://wx.locqj.top/api/client/settarget',
            data: {
              openid: that.data.openid,
              target_step: that.data.step
            },
            method: 'POST',
            success: function(res) {
              if (res.data.original.code == 1) {

                wx.showToast({
                  title: '成功',
                  icon: 'success',
                  duration: 2000,
                  success: function() {
                    wx.hideLoading()
                  }
                })
              }
            }
          })
        } else if (res.cancel) {
          // console.log('用户点击取消')
        }
      }
    })

  }
})