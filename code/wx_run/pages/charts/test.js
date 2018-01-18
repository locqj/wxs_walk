  function GetLocalIPAddress() {
    var obj = null;
    var rslt = "";
    try {
      obj = new ActiveXObject("rcbdyctl.Setting");
      rslt = obj.GetIPAddress;
      obj = null;
    }
    catch (e) {
      //异常发生
    }
    return rslt;
  }
  module.exports.GetLocalIPAddress = GetLocalIPAddress; 