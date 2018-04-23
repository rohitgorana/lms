class magic{
    constructor(data, add = null) {
        this.data = data;
        this.additional = add;
        this.markup = '';

        this.get = function() {
            
        };
        this.init = function() {
        };
    }
}


function formElement(args, add = null){
    this.type = null;
    this.name = '';
    this.placeholder = "";
    this.selectOptions = [];
    this.submitButtonText = "";
    this.value = "";
    this.markup = "";
    this.master = null;
    this.additional = add;
    this.defaultOption = null;
    this.mask = null;

    for(var arg in args){
        if(this.hasOwnProperty(arg))
            this[arg] = args[arg];
    }

    this.get = function(){


        switch(this.type){
          case 'text'   :   this.markup += `<div class="form-group">
                                              <input type="text" class="form-control" name="`+this.name+`"  placeholder="`+this.placeholder+`" value = "${this.value}" required>
                                            </div>`;
                            break;

          case 'password'   :   this.markup += `<div class="form-group">
                                                <input type="password" class="form-control" name="`+this.name+`"  placeholder="`+this.placeholder+`" required>
                                            </div>`;
                            break;

          case 'tel'   :   this.markup += `<div class="form-group">
                                              <input type="tel" class="form-control" name="`+this.name+`"  placeholder="`+this.placeholder+`" required>
                                            </div>`;
                            break;

          case 'select' :   this.markup+= `<div class="form-group">
                                              <select name="`+this.name+`" class="form-control upload-form-textbox" required>
                                        `;
                            if(this.defaultOption != null){
                              this.markup += `<option disabled selected value>`+this.defaultOption+`</option>`;
                            }
                            for(var i=0; i< this.selectOptions.length; i++){
                              if(typeof this.selectOptions[i] === 'object')
                                this.markup += `<option value="${this.selectOptions[i].value}">`+this.selectOptions[i].name+`</option>`;
                              else
                                this.markup += `<option>`+this.selectOptions[i]+`</option>`;
                            }

                            this.markup+=`</select></div>`;
                            break;
          case 'hidden'   :   this.markup += `<div class="form-group">
                                              <input type="hidden" class="form-control" name="`+this.name+`"  value = "`+this.value+`">
                                            </div>`;
                            break;

          case 'number'  :  this.markup += `<div class="form-group">
                                              <input class="form-control" type="number" name="`+this.name+`"  placeholder="`+this.placeholder+`">
                                            </div>`;
                            break;

          case 'submit':  this.markup += `<div class="form-group">
                                            <div class="row">
                                              <div class="col-md-12">
                                                <button type="submit" name="`+this.name+`" class="btn form-btn pull-right">`+this.placeholder+`</button>
                                              </div>
                                            </div>
                                          </div>`;
                            break;

        }


        return this.markup;
    }

    this.init = function(){
      var self = this;
      if(self.master != null){
        var form = '#'+self.master.form;
        $( form + ' *[name='+ self.name+']').hide();
        var master = self.master, name = self.name;
        $(form + ' select[name='+ self.master.name+']').change(function(){
          if($(form + ' select[name='+ master.name+']').find(":selected").val() == master.value){
            $(form + ' *[name='+ name+']').show();
          }
          else {
            $(form + ' *[name='+ name+']').hide();
          }
        });
      }

      if(self.mask !=null){
        $('#'+ self.mask.form + ' *[name='+self.name+']').mask(self.mask.value);
      }
    }

}

function form(data, add = null){

  this.id = "form";
  this.action = "#";
  this.method = "GET";
  this.upload = false;
  this.elements = [];
  this.markup = "";
  this.grid = [1];
  this.additional = add;
  this.onsuccess = function(data){};
  this.dataUrl = null;
  this.data = null;

  for(var arg in data){
      if(this.hasOwnProperty(arg))
          this[arg] = data[arg];
  }

  this.get = function(){


      this.markup += `<form id="`+this.id+`" action="`+this.action+`">`;
          for(var i =0; i<this.elements.length; ++i){
            this.elements[i] = new formElement(this.elements[i]);
              this.markup += this.elements[i].get();
          }
      this.markup += `</form>`;


      return this.markup;

  }




  this.init = function(id){
    var self = this;
    for(var i=0; i< this.elements.length; i++){
      this.elements[i].init();
    }

    $('#'+this.id).on('submit', function(e){
      e.preventDefault();
      if(self.upload)
        var data = new FormData(this);
      else
        var data = $(this).serialize();
      console.log(data);
      if(self.data !=null)
        data = {
          data: JSON.stringify(window[self.data])
        };

      if(self.upload){
        http.upload(HOST_PATH + $(this).attr('action'), data, self.onsuccess);
      }
      else
        http.post(HOST_PATH + $(this).attr('action'), data, self.onsuccess);
      $(this).trigger('reset');
    });

    if(self.dataUrl !=null){
      http.get(self.dataUrl, function(data){
        $('form#'+self.id+' :input').not('form#'+self.id+' :input[type=checkbox], input[type=hidden]').each(function(){
          $(this).val(data[$(this).attr('name')]);
        });
        $('form#'+self.id+' :input[type=checkbox]').each(function(){
          var name = $(this).attr('name').replace('[]', '');
          var value = $(this).attr('value');


          if(data[name].indexOf(parseInt(value)) != -1){
            $(this).prop('checked', true);
          }

        });
        for(var field in data){
          $('#'+self.id).find('*[name='+field+']').val(data[field]);
        }
      });
    }



  }


}