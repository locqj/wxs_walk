Page({
  data: {
    imgUrls: [
      'http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175866434296.jpg',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'
    ],
    step: 0
  },
  onchange: function(e) {
    let current = e.detail.current
    let step = 0
    console.log(current)
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
    this.setData({step: 8000})
  }
})