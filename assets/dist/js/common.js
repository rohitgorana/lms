var HOST_PATH = "/lms/";

var http = {
    get: function(url, onsuccess=null){
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data)
            {
                var res = JSON.parse(data);
                console.log(res);
                if(res.code == -1)
                {

                    window.location.replace(res.data);
                }
                else if(res.code == 0)
                    alert(res.message);
                else{
                  if(onsuccess != null)
                    onsuccess(res.data);
                }

            }
        });
    },

    post: function(url, data, onsuccess=null){
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(data)
            {
                var res = JSON.parse(data);
                console.log(res);

                if(res.code == -1)
                {

                    window.location.replace(res.data);
                }
                else if(res.code == 0)
                    alert(res.message);
                else{
                  if(onsuccess != null)
                    onsuccess(res.data);
                }

            }
        });
    },

    upload: function(url, data, onsuccess=null){
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                var res = JSON.parse(data);
                console.log(res);

                if(res.code == -1)
                {
                    window.location.replace(res.data);
                }
                else if(res.code == 0)
                    alert(res.message);
                else{
                  if(onsuccess != null)
                    onsuccess(res.data);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }






}

function loadScript(url, callback){

  var script = document.createElement("script")
  script.type = "text/javascript";

  if (script.readyState){  //IE
    script.onreadystatechange = function(){
      if (script.readyState == "loaded" ||
      script.readyState == "complete"){
        script.onreadystatechange = null;
        callback();
      }
    };
  } else {  //Others
    script.onload = function(){
      callback();
    };
  }

  script.src = url;
  document.getElementsByTagName("head")[0].appendChild(script);
}

jQuery.fn.extend({
  attach: function(component,id, param = null){
     return this.each(function(){
      $(this).append(component.get());
      if(param == null)
        component.init(id);
      else
        component.init(id,param);
    });


  }
});


function createCookie(name, value, days) {
    var date, expires;
    if (days) {
        date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = "; expires="+date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
