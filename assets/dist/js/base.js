
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

function editMenu(){

        this.type = null;
        this.noOfOptions = null;
        this.options=null;
        this.form = null;

        this.get = function(type = null, noOfOptions = 1, options = null, form = null){
            this.markup += `<div class="social-widget">
                                                                                                <ul>
                                                                                                    <li>
                                                                                                        <div class="twitter_inner">
                                                                                                            <i class="fa fa-twitter"></i>
                                                                                                            <span class="sc-num">691</span>
                                                                                                            <small>Followers</small>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <div class="twitter_inner">
                                                                                                            <i class="fa fa-twitter"></i>
                                                                                                            <span class="sc-num">691</span>
                                                                                                            <small>Followers</small>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <div class="twitter_inner">
                                                                                                            <i class="fa fa-twitter"></i>
                                                                                                            <span class="sc-num">691</span>
                                                                                                            <small>Followers</small>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <div class="twitter_inner">
                                                                                                            <i class="fa fa-twitter"></i>
                                                                                                            <span class="sc-num">691</span>
                                                                                                            <small>Followers</small>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>`;
            return this.markup;
        }

}

function userSelectList(data, add = null){
  this.data = data;
  this.additional = add;
  this.markup = ``;

  this.get = function(){
    this.markup += `<div class="panel panel-bd">
                      <div class="panel-body">
                      <div class="table scroll">
                        <table class="table table-bordered table-striped table-hover user-select-list">
                          <thead>
                            <tr>
                              <th></th>`;
                              for(var j=0; j<this.data.noOfColumns; j++){
                                  this.markup += `<th>`+this.data.columnNames[j].toUpperCase()+`</th>`;

                              }
                              if(this.additional == 'sessional')
                                this.markup += `<th></th>`;
    this.markup +=           `
                            </tr>
                          </thead>
                          <tbody>`;
                            for(var j=0; j<this.data.data[0].length; j++){
                                this.markup += `<tr data-id="`+this.data.data[0][j][this.data.data[0][j].length-1]+`">
                                                  <td>
                                                    <div class="checkbox"><input id="user`+this.data.data[0][j][this.data.data[0][j].length-1]+`" value="`+this.data.data[0][j][this.data.data[0][j].length-1]+`" type="checkbox" name ="users[]">
                                                      <label for="user`+this.data.data[0][j][this.data.data[0][j].length-1]+`"></label>
                                                    </div>
                                                  </td>`;
                                                  for(var k=0; k<this.data.noOfColumns; k++){
                                                      this.markup += `<td>`+this.data.data[0][j][k]+`</td>`;
                                                  }

                                                  if(this.additional == 'sessional'){
                                                    this.markup += `
                                                    <td>
                                                      <div class="row">
                                                          <div class="col-md-1">
                                                              <i class="panel-control-icon fa fa-clock-o pointer durationBtn" data-toggle="modal" data-target="#small-modal"></i>

                                                          </div>
                                                      </div>
                                                    </td>`;
                                                  }
                                                  this.markup += `</tr>
                                                  `;



                            }
                            this.markup += `
                        </tbody>
                  </table>
              </div>
          </div>
          </div>`;
          return this.markup;
  }

  this.init = function(id,currId){
    $('.user-select-list').DataTable({
        "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "lengthMenu": [[6, 25, 50, -1], [6, 25, 50, "All"]],
        "iDisplayLength": 6
    });
    $('.durationBtn').click(function(e){
      var studId = $(e.currentTarget).closest('tr').attr('data-id');
      $('#small-modal').find('h1').text('Extend Period');
      $('#small-modal').find('.modal-body').empty().attach(new form({
        id: 'extendStudCurrForm',
        action: 'dashboard/extendStudCurrPeriod',
        elements:[
          {
            type: 'hidden',
            value: currId,
            name: 'curr'
          },
          {
            type: 'hidden',
            value: studId,
            name: 'student'
          },
          {
            type: 'number',
            name: 'duration',
            placeholder: 'No of Weeks'
          },
          {
            type: 'submit',
            placeholder : 'Save'
          }
        ],
        onsuccess: function(data){
          $('#small-modal').modal('toggle');

        }

      }), id);
    });
    $('.scroll').slimScroll({
      size: '3px',
      height: '50vh'
    });
  }
}


function dataTable(data, add = null){
        this.data = data;
        this.additional = add;
        this.markup = "";

        this.get = function(){

            if(this.data.noOfTabs == null){
              this.markup += `<div class="panel panel-bd">
                                <div class="panel-body">
                                <div class="table scroll-x">
                                  <table class="table table-bordered table-striped table-hover" id="${this.data.name}">
                                    <thead>
                                      <tr>`;

              if(this.additional != false){
                this.markup += `<th></th>`;
              }
                                        for(var j=0; j<this.data.noOfColumns; j++){
                                            this.markup += `<th>`+this.data.columnNames[j].toUpperCase()+`</th>`;

                                        }
              if(this.additional != false){
                this.markup  += `<th>MANAGE</th>`;
              }
              this.markup +=           `
                                      </tr>
                                    </thead>
                                    <tbody>`;
                                      for(var j=0; j<this.data.data.length; j++){
                                          this.markup += `<tr data-id="`+this.data.data[j][this.data.data[j].length-1]+`">`;
                                          if(this.additional != false){
                                            this.markup += `<td>
                                                <div class="checkbox"><input id="checkbox`+this.data.data[j][this.data.data[j].length-1]+`" type="checkbox">
                                                  <label for="checkbox`+this.data.data[j][this.data.data[j].length-1]+`"></label>
                                                </div>
                                            </td>`;
                                          }

                                          for(var k=0; k<this.data.noOfColumns; k++){
                                            this.markup += `<td>`+this.data.data[j][k]+`</td>`;
                                          }

                                          if(this.additional != false){
                                            this.markup += `
                                            <td>
                                              <span class="label delete-label panel-control-icon deleteModal pointer">Delete</span>
                                            </td>`;
                                          }



                                      }
                                      this.markup += `</tr>
                                  </tbody>
                            </table>
                        </div>
                    </div>
                    </div>`;
                    return this.markup;
            }
            else {

              this.markup += `<ul class="nav nav-tabs">`;
              for(var i=0; i<this.data.noOfTabs; ++i){
                  if(i==0)
                      this.markup += `<li class="active"><a href="#tab1" data-toggle="tab">`+this.data.tabNames[i].toUpperCase()+`</a></li>`;
                  else {
                      this.markup += `<li><a href="#tab`+(i+1)+`" data-toggle="tab">`+this.data.tabNames[i].toUpperCase()+`</a></li>`;
                  }
              }


                this.markup+=`</ul>`;
                this.markup+= `<div class="tab-content">`;
                  for(var i=0; i<this.data.noOfTabs; i++){
                    if(i==0)
                      this.markup += `<div class="tab-pane fade in active" id="tab`+(i+1)+`">`;
                    else
                      this.markup += `<div class="tab-pane fade" id="tab`+(i+1)+`">`;

                    this.markup += `<div class="panel-body">
                                      <div class="table scroll-x">
                                        <table class="table table-bordered table-striped table-hover" id="${this.data.name+'-'+this.data.tabNames[i]}">
                                          <thead>
                                            <tr>
                                              <th></th>`;
                                              for(var j=0; j<this.data.noOfColumns; j++){
                                                  this.markup += `<th>`+this.data.columnNames[j].toUpperCase()+`</th>`;

                                              }
                    this.markup +=           `<th>MANAGE</th>
                                            </tr>
                                          </thead>
                                          <tbody>`;
                                            for(var j=0; j<this.data.data[i].length; j++){
                                                this.markup += `<tr data-id="`+this.data.data[i][j][this.data.data[i][j].length-1]+`">
                                                                  <td>
                                                                    <div class="checkbox"><input id="checkbox`+this.data.data[i][j][this.data.data[i][j].length-1]+`" type="checkbox">
                                                                      <label for="checkbox`+this.data.data[i][j][this.data.data[i][j].length-1]+`"></label>
                                                                    </div>
                                                                  </td>`;
                                                                  for(var k=0; k<this.data.noOfColumns; k++){
                                                                      this.markup += `<td>`+this.data.data[i][j][k]+`</td>`;
                                                                  }
                                                                  this.markup += `
                                                                  <td>
                                                                    <span class="label delete-label panel-control-icon deleteModal pointer">Delete</span>
                                                                  </td>`;



                                            }
                                            this.markup += `</tr>
                                        </tbody>
                                  </table>
                              </div>
                          </div>
                        </div>

                        `;



                  }

                this.markup += `</div>`;
                return this.markup;


              }
          }

          this.init = function(id){
            if(this.data.noOfTabs == null){
              $('#'+ this.data.name).DataTable({
                  "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                  "lengthMenu": [[6, 25, 50, -1], [6, 25, 50, "All"]],
                  "iDisplayLength": 6
              });
            }
            else {
              for(var i=0; i<this.data.noOfTabs; ++i){
                $('#'+ this.data.name+'-'+this.data.tabNames[i]).DataTable({
                    "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                    "lengthMenu": [[6, 25, 50, -1], [6, 25, 50, "All"]],
                    "iDisplayLength": 6
                });
              }
            }

            $('.deleteModal').on("click", function (e) {
                      swal({
                          title: "Are you sure?",
                          text: "You will not be able to recover this imaginary file!",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: "Yes, delete it!",
                          cancelButtonText: "No, cancel pls!",
                          closeOnConfirm: false,
                          closeOnCancel: false},
                              function (isConfirm) {
                                  if (isConfirm) {
                                    switch(id){
                                      case 'user'       : var userId = $(e.currentTarget).closest('tr').attr('data-id');

                                                          http.get('/lms/dashboard/deleteUser/'+userId, function(data){
                                                            swal("Deleted!", "User is deleted.", "success");
                                                            $(e.currentTarget).closest('tr').remove();
                                                          });

                                                          break;

                                      case 'institute'  : var insId = $(e.currentTarget).closest('tr').attr('data-id');
                                                          http.get('/lms/dashboard/deleteInstitute/'+insId, function(data){
                                                            swal("Deleted!", "Institute is deleted.", "success");
                                                            $(e.currentTarget).closest('tr').remove();
                                                          });
                                                          break;
                                      case 'course'     :
                                                          break;
                                    }


                                  } else {
                                      swal("Cancelled", "It is safe :)", "error");
                                  }
                              });
                  });
          }

}

function stats(data, add = null){


    this.data = data;
    this.additional = add;
    this.markup = ``;

    this.get = function(){
      this.markup += `<div class="header-title">
                        <div class="row" id="statsBox">`;
      for(var stat in this.data){
        this.markup += `<div class="col-md-2 fl">
                                <h1>`+stat.toUpperCase()+`</h1>
                                <small>`+this.data[stat]+`</small>
                            </div>`;
      }

      this.markup += `<button type="button" id="addNewButton" class="btn form-btn pull-right" data-toggle="modal" data-target="#utility-modal">Add New </button>
                      </div>
                    </div>`;

      return this.markup;
    };

    this.init = function(id){
      $('#addNewButton').append(id);
    }

}

// function stackTile(){
//
//     this.markup = ``;
//
//     this.get = function(data){
//       this.markup += `<div class="row">`;
//       for(var i=0; i<data.length; i++){
//         this.markup += `<div class="col-sm-12 col-md-12">
//                             <div class="panel panel-bd">
//                                 <div class="panel-body">
//                                     <div class="statistic-box">
//                                         <h3><span class="count-number">`+data[i]+`</span></h3>
//
//
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>`;
//
//       }
//       this.markup +=`</div>`;
//
//       return this.markup;
//     }
//
// }
//
// function courseList(){
//
//         this.markup = ``;
//
//         this.get = function(data){
//             this.markup += `<div class="row">
//                             <div class="col-sm-12 col-md-12">
//                                 <div class="panel panel-bd">
//                                     <div class="panel-body">
//                                         <div class="dd" id="nestable">`;
//
//             this.markup += generate(data, 0);
//
//             this.markup += `        </div>
//                                 </div>
//                             </div>
//                         </div>
//
//                     </div>`;
//
//
//             function generate(data, depth) {
//
//                 var markup = `<ol class="dd-list">`;
//
//                 for(var element in data){
//                     var ele_id = data[element].id;
//                     var ele_child = data[element].children;
//
//                     markup += `<li class="dd-item"  data-id="`+data[element].id+`">`;
//
//
//                     if (ele_child == null) {
//
//                         if (depth == 4) {
//
//                           markup += `<div class="handle">
//                                                    `+element+`
//                                                    <div class="pull-right">
//                                                       <i class="fa fa-pencil mlr5 subEditBtn" title="Edit"></i>
//                                                       <i class="fa fa-remove mlr5 subRemBtn" title="Remove"></i>
//                                                    </div>
//                                               </div>`;
//
//                         }
//                         else {
//                           markup +=`<div class="handle">
//                                                    `+element+`
//                                                    <div class="pull-right">
//                                                       <i class="fa fa-plus mlr5 subAddBtn" data-toggle="modal" data-target="#sub-modal" title="Add"></i>
//                                                       <i class="fa fa-pencil mlr5 subEditBtn" title="Edit"></i>
//                                                       <i class="fa fa-remove mlr5 subRemBtn" title="Remove"></i>
//                                                    </div>
//                                               </div>`;
//                         }
//                     }
//                     else {
//                         markup +=`<div class="handle">
//                                                  `+element+`
//                                                  <div class="pull-right">
//                                                     <i class="fa fa-plus mlr5 subAddBtn" data-toggle="modal" data-target="#sub-modal" title="Add"></i>
//                                                     <i class="fa fa-pencil mlr5 subEditBtn" title="Edit"></i>
//                                                     <i class="fa fa-remove mlr5 subRemBtn" title="Remove"></i>
//                                                  </div>
//                                             </div>`;
//                         markup += generate(data[element].children, depth+1);
//
//                     }
//                     markup += `</li>`;
//
//                 }
//                 markup +=`</ol>`;
//                 return markup;
//
//             }
//             return this.markup;
//
//
//         }
//
//
//
// }


function currList(data, add = null){
        this.data = data;
        this.additional = add;

        this.markup = ``;

        this.get = function(){

          this.markup += `<div class="row">`;
          this.markup += generate(this.data);
          this.markup += `</div>`;

          function generate(data) {
            var markup = ``;

            for(var i=0; i<data.length; i++){
                markup += `<div class="col-md-3 mtb10 curr-item" data-id="`+data[i].id+`" data-type="`+data[i].type+`">
                            <div class="grid cs-style-3">
                              <figure>
                                  <div class="panel panel-bd m0 h22">
                                    <div class="panel-body">
                                        <div class="grid-tag"></div>
                                        <h3 class="pull-left mt8">`+data[i].name+`</h3>
                                    </div>
                                  </div>
                                  <figcaption>
                                    <i class="fa fa-users mlr15 pointer subUserBtn" data-toggle="modal" data-target="#large-modal" title="Students"></i>
                                    <i class="fa fa-book mlr15 pointer subCourseBtn" data-toggle="modal" data-target="#sub-modal" title="Courses"></i>
                                    <i class="fa fa-edit mlr15 pointer subEditBtn" data-toggle="modal" data-target="#sub-modal" title="Edit"></i>
                                    <i class="fa fa-remove mlr15 pointer subRemBtn" title="Remove"></i>
                                  </figcaption>
                              </figure>
                            </div>
                          </div>`;


            }
            return markup;
          }

          return this.markup;
        }
        this.init = function(id){
          var self = this;
          var colors = ['#c1cdce','#b0dbde','#f1d7d7','#dec9e4','#e0d2ef','#bfdcf7','#b5ecec','#b2ecd4','#e3eaa7','#efdba4','#ecc0c0','#aba2a2'];
          var dark = ['#828d8e','#74a6ab' ,'#bf8d8d' , '#a06d95' ,'#a878b7' ,'#8b9cda' , '#6eb5b9','#71b797','#939c64','#af9c71','#9a6464','#735e5e']
          $('.curr-item').each(function(){
            var color = Math.floor((Math.random() * 12) + 0);
            $(this).find('.panel').css('background', colors[color]);
            $(this).find('.grid-tag').css('background', dark[color]);
          });
          var users = this.additional.users;
          $('.subUserBtn').click(function(e){
              var currId = $(e.currentTarget).closest('.curr-item').data('id');
              var currType = $(e.currentTarget).closest('.curr-item').data('type');
              var studentsList = new userSelectList(users, currType);

              $('#large-modal').find('.modal-body').empty().attach(new form({
                id: 'addStudentsForm',
                action: 'dashboard/addStudentsToCurr',
                elements:[
                  {
                    type: 'hidden',
                    value: currId,
                    name: 'curr'
                  },
                  {
                    type: 'custom',
                    markup: studentsList.get()
                  },
                  {
                    type: 'submit',
                    placeholder : 'Save'
                  }
                ],
                onsuccess: function(data){
                  $('#large-modal').modal('toggle');

                },
                dataUrl: HOST_PATH + 'dashboard/getCurriculumStudents/'+ currId

              }), id);
              studentsList.init(id,currId);
            });

            $('.subCourseBtn').click(function(e){
                // var courseSelectList = new finder([self.additional.courses.topics]);
                var courseSelectList = new dirSelectList(self.additional.courses.topics);
                var currId = $(e.currentTarget).closest('.curr-item').attr('data-id');
                $('#sub-modal').find('h1').text('Add Courses');
                $('#sub-modal').find('.modal-body').empty().attach(new form({
                  id: 'addCoursesForm',
                  action: 'dashboard/addCourseToCurr',
                  elements:[
                    {
                      type: 'hidden',
                      value: currId,
                      name: 'curr'
                    },
                    {
                      type: 'custom',
                      markup: courseSelectList.get()
                    },
                    {
                      type: 'submit',
                      placeholder : 'Save'
                    }
                  ],
                  onsuccess: function(data){
                    $('#sub-modal').modal('toggle');

                  },
                  dataUrl: HOST_PATH + 'dashboard/getCurriculumCourses/' + currId


                }), id);
                courseSelectList.init(id);
            });

            $('.subEditBtn').click(function(e){
              var currId = $(e.currentTarget).closest('.curr-item').attr('data-id');
                $('#sub-modal').find('h1').text('Edit Curriculum');
                $('#sub-modal').find('.modal-body').empty().attach(new form({

                                        id: 'editCurrForm',
                                        action: 'dashboard/editCurr',
                                        elements:[
                                          {
                                            type: 'hidden',
                                            value: currId,
                                            name: 'id'
                                          },
                                          {
                                            type: 'text',
                                            name: 'name',
                                            placeholder: 'Name'
                                          },
                                          {
                                            type: 'select',
                                            name: 'type',
                                            selectOptions: [
                                              {
                                                name:"General",
                                                value:"general"
                                              },
                                              {
                                                name: "Semester",
                                                value: "sessional"
                                              }
                                            ]
                                          },
                                          {
                                            type: 'number',
                                            name: 'duration',
                                            placeholder: 'No Of Weeks',
                                            master: {
                                              form: 'editCurrForm',
                                              name: 'type',
                                              value: 'sessional'
                                            }
                                          },
                                          {
                                            type: 'submit',
                                            placeholder : 'Save'
                                          }
                                        ],
                                        onsuccess: function(data){
                                          $('#sub-modal').modal('toggle');

                                        },
                                        dataUrl: HOST_PATH + 'dashboard/getCurrInfo/' + currId

                                      }), id);
            });

            $('.subRemBtn').click(function (e) {
              swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel pls!",
                closeOnConfirm: false,
                closeOnCancel: false},

                function (isConfirm) {
                  if (isConfirm) {
                    http.get(HOST_PATH + 'dashboard/deleteCurr/' + $(e.currentTarget).closest('.curr-item').attr('data-id'), function(data){
                                                            swal("Deleted!", "Curriculum is deleted.", "success");
                                                            $(e.currentTarget).closest('.curr-item').remove();
                                                          });
                  } else {
                      swal("Cancelled", "It is safe :)", "error");
                  }
              });

            });




        }
    }



function dirSelectList(data, add = null){
        this.data = data;
        this.additional = add;
        this.markup = ``;

        this.get = function(){
            this.markup += `<div class="panel panel-bd">
                            <div class="panel-body">
                                    <div class="panel-heading">
                                        <h4 class="multiple-select-heading">Select Courses :</h4>
                                    </div>
                                    <div class="panel-body border-top">
                                        <ol class="scroll">`;
            this.markup += generate(this.data);
            this.markup += `</ol>
                          </div>
                        </div>
                      </div>`;

            function generate(data){
                var markup = ``;

                for(var element in data){
                    markup += `<li data-id="`+data[element].id+`">`;

                    markup += `<div class="checkbox checkbox-primary mtb15">
                                  <input id="checkbox`+data[element].id+`" type="checkbox" value="`+data[element].id+`" name="dir[]">
                                  <label for="checkbox`+data[element].id+`">`+data[element].name+`</label>
                              </div>`;
                }
                return markup;
            }
            return this.markup;


        }

        // this.get = function(){
        //     this.markup += `<div class="dd scroll" id="nestable">`;
        //
        //     this.markup += generate(this.data, 0);
        //     this.markup += `</div>`;
        //
        //
        //     function generate(data, depth) {
        //
        //         var markup = `<ol class="dd-list">`;
        //
        //         for(var element in data){
        //             var ele_id = data[element].id;
        //             var ele_child = data[element].children;
        //
        //             markup += `<li class="dd-item"  data-id="`+data[element].id+`">`;
        //
        //             markup +=`<label class="wrap-label" for="checkbox`+data[element].id+`"><div class="handle">
        //                                          `+data[element].name+`
        //                                          <div class="pull-right">
        //                                             <div class="checkbox checkbox-success m0">
        //                                                     <input id="checkbox`+data[element].id+`" type="checkbox" value="`+data[element].id+`" name="dir[]">
        //                                                     <label for="checkbox`+data[element].id+`"></label>
        //                                             </div>
        //                                          </div>
        //                                     </div></label>`;
        //             if(ele_child != null)
        //               markup += generate(data[element].children, depth+1);
        //
        //
        //
        //         }
        //         markup +=`</ol>`;
        //         return markup;
        //
        //     }
        //     return this.markup;
        //
        //
        // }

        this.init = function(id){
          $('.scroll').slimScroll({
            size: '3px',
            height: '50vh'
          });
          $('#nestable').nestable({
              group: 1
          });
        }



}


function learningHistory(data, add = null){
        this.data = data;
        this.additional = add;
        this.markup = ``;


        this.get = function(){
          if(this.data.length > 0)
          {
            this.markup += `<div class="row">
                      <div class="col-sm-12">
                          <h4 class="student-dashboard-heading">Latest Activity</h4>
                          <div class="panel panel-bd student-dashboard-panel">
                              <div class="panel-body">
                                  <div class="row student-dashboard-row">`;
            if(this.data[0].status == 'active')
            {
              this.markup +=       `<h3 class="student-dashboard-h3">Do you want to continue `+ this.data[0].name +`?</h3>
                                    <button type="button" class="btn btn-primary student-dashboard-resume-btn resume-btn" name="button" data-id="`+this.data[0].id+`" data-curr="`+this.data[0].curriculum+`">Resume Learning</button>`;
            }
            else {
              this.markup +=       `<h3 class="student-dashboard-h3">You were at `+ this.data[0].name +`?</h3>`;
            }
            this.markup +=       `</div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                        <div class="col-sm-12">
                          <h4 class="student-dashboard-h4">Recent Activities</h4>
                            <div class="main">
                                <ul class="cbp_tmtimeline">`;


            if(this.data.length > 1){
              for(var i=1; i<this.data.length; i++){
                this.markup += `      <li>
                                          <time class="cbp_tmtime" datetime="`+this.data[i].time+`"><span>`+this.data[i].time.split(' ')[0]+`</span> <span>`+this.data[i].time.split(' ')[1]+`</span></time>
                                          <i class="fa fa-tv"></i>
                                          <div class="cbp_tmlabel student-dashboard-activity-panel">
                                                <h2>`+this.data[i].name+`</h2>`;
                if(this.data[i].status == 'active'){
                  this.markup +=               `<button type="button" name="button" class="student-dashboard-activity-btn resume-btn" data-id="`+this.data[i].id+`" data-curr="`+this.data[i].curriculum+`"> View
                                                  <span class="fa fa-angle-right" style=""></span>

                                                </button>`;

                }
                else {
                  this.markup +=                '<p>This Item is expired.</p>'
                }
               this.markup +=             `<div class="student-dashboard-progress-panel1" style="display:none;">
                                                    <div class="student-dashboard-progress-panel2">
                                                      <div class="progress progress-sm student-dashboard-progress-panel3">
                                                          <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 10%">

                                                          </div>
                                                      </div>
                                                        <span class="student-dashboard-progress-tooltip">40% viewed</span>
                                                    </div>
                                                </div>
                                          </div>
                                      </li>`;
              }
            }



            this.markup +=     `</ul>
                            </div>
                        </div>
                    </div>`;

          }
          else {
            this.markup += `<div class="row">
              <div class="col-sm-12">
                  <h4 class="student-dashboard-heading">Latest Activity</h4>
                  <div class="panel panel-bd student-dashboard-panel">
                      <div class="panel-body">
                          <div class="row student-dashboard-row">
                              <h3 class="student-dashboard-h3">Welcome! Let's dig in.</h3>

                              <p class="student-dashboard-para">Your activity will be shown here once you start learning</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>`;
          }
          return this.markup;


        }

        this.init = function(id){
          $('.resume-btn').click(function(){
            sessionStorage.setItem('content', $(this).data('id'));
            sessionStorage.setItem('curriculum', $(this).data('curr'));
              window.location.href = "classroom";
          });
        }





}

function sidebarContent(data, add = null){

    this.data = data;
    this.additional = add;
    this.markup = ``;

    this.get = function(){

      function turbine(children){
          var markup = `<ul class="treeview-menu">`;
          for(var i =0; i<children.length; i++){
              var child = children[i];

              if(child.children.length>0){
                  markup += `<li>
                      <a href="#">`+child.name+`
                          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                      </a>`;
                  markup += turbine(child.children);
              }
              else{
                   markup += `<li class="sidebarItem"`;
                   for(var key in child.data){
                     markup += ` data-`+ key+ `="`+child.data[key]+`"`;
                   }
                   markup += `>
                      <a>`+child.name+`</a>`;
              }
              markup += `</li>`;

          }
          markup += `</ul>`;

          return markup;
      }

      for(var section in data){
        this.markup += `<li class="header">`+section+`</li>`;

        for(var i=0; i<this.data[section].length; i++)
        {
          var module = this.data[section][i];
          if(module.children.length >0){
            this.markup += `<li class="treeview">
            <a href="#">
                <i class="ti-`+module.name+`"></i> <span>`+module.name+`</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>`;
            this.markup += turbine(module.children);
          }
          else{
            this.markup += `<li class="treeview sidebarItem"`;
            for(var key in module.data){
              this.markup += ` data-`+ key+ `="`+module.data[key]+`"`;
            }
            this.markup += `>
            <a href="#">
                <i class="ti-`+module.name+`"></i> <span>`+module.name+`</span>
            </a>`;
          }

          this.markup += `</li>`;
        }

      }

      return this.markup;
    }

    this.init = function(id,cover){

      $('.sidebarItem').click(function(){
        $('.sidebarItem.active').removeClass('active');
        $(this).addClass('active');
        $('#SectionTitle').text(($(this).attr('data-id')+'s').toUpperCase());

        cover($(this).data());
      });
    }

}


function addNewForm(type,add = null){

    this.type = type;
    this.form = null;
    this.additional = add;
    switch(this.type){
      case 'user'       : this.form = {
                            id: 'newUserForm',
                            action: 'dashboard/addNewUser',
                            elements:[
                              {
                                type: 'text',
                                name: 'fullname',
                                placeholder: 'Fullname'
                              },
                              {
                                type: 'text',
                                name: 'email',
                                placeholder: 'Email'
                              },
                              {
                                type: 'text',
                                name: 'username',
                                placeholder: 'Username'
                              },
                              {
                                type: 'password',
                                name: 'password',
                                placeholder: 'Password'
                              },
                              {
                                type: 'select',
                                name: 'role',
                                selectOptions: this.additional.roles,
                                defaultOption: '--select role--'
                              }

                            ],
                            onsuccess: function(data){
                              $('#utility-modal').modal('toggle');
                              http.get(HOST_PATH + 'dashboard/getUserManagement', function(data){
                                for(var element in data.main){
                                  element = new this[element](data.main[element], data.additional);
                                  $('#mainContent').empty().attach(element,'user');

                                }

                                for(var element in data.header){
                                    element = new this[element](data.header[element], data.additional);
                                    $('.content-header').empty().attach(element,'user');
                                }


                              });
                            }

                          };
                          if(this.additional.hasOwnProperty('institutes'))
                          {
                            this.form.elements.push({
                              type: 'select',
                              name: 'institute',
                              selectOptions: this.additional.institutes,
                              defaultOption: '--select institute--'
                            }
                          );
                          }
                          this.form.elements.push(
                            {
                              type: 'submit',
                              placeholder: 'ADD'
                            }
                          );
                          break;

      case 'institute'  : this.form = {
                          id: 'newInsForm',
                          action: 'dashboard/addNewInstitute',
                          elements:[
                            {
                              type: 'text',
                              name: 'name',
                              placeholder: 'Name'
                            },
                            {
                              type: 'text',
                              name: 'code',
                              placeholder: 'Code'
                            },
                            {
                              type: 'text',
                              name: 'website',
                              placeholder: 'Website'
                            },
                            {
                              type: 'text',
                              name: 'address',
                              placeholder: 'Address'
                            },
                            {
                              type: 'tel',
                              name: 'contactno',
                              placeholder: 'Contact No.'
                            },
                            {
                              type: 'number',
                              name: 'limit',
                              placeholder: 'Student Limit'
                            },

                            {
                              type: 'submit',
                              placeholder : 'Add'
                            }
                          ],
                          onsuccess: function(data){
                            $('#utility-modal').modal('toggle');
                            http.get(HOST_PATH + 'dashboard/getInstituteManagement', function(data){

                              for(var element in data.main){
                                element = new this[element](data.main[element], data.additional);
                                $('#mainContent').empty().attach(element,'institute');

                              }

                              for(var element in data.header){
                                  element = new this[element](data.header[element], data.additional);
                                  $('.content-header').empty().attach(element,'institute');
                              }


                            });
                          }

                          };
                          break;

      case 'course'     : this.form = {
                          id: 'newCourseForm',
                          action: 'dashboard/addNewDir',
                          elements:[
                            {
                              type: 'text',
                              name: 'name',
                              placeholder: 'Name'
                            },
                            {
                              type: 'submit',
                              placeholder : 'Add'
                            }
                          ],
                          onsuccess: function(data){
                            $('#utility-modal').modal('toggle');
                            location.reload();
                          }

                          };
                          break;


      case 'curriculum' : this.form =  {
                            id: 'newCurrForm',
                            action: 'dashboard/addNewCurr',
                            elements:[
                              {
                                type: 'text',
                                name: 'name',
                                placeholder: 'Name'
                              },
                              {
                                type: 'select',
                                name: 'type',
                                selectOptions: [
                                  {
                                    name:"General",
                                    value:"general"
                                  },
                                  {
                                    name: "Semester",
                                    value: "sessional"
                                  }
                                ],
                                defaultOption: '--Select Type--'
                              },
                              {
                                type: 'number',
                                name: 'duration',
                                placeholder: 'No Of Weeks',
                                master: {
                                  form: 'newCurrForm',
                                  name: 'type',
                                  value: 'sessional'
                                }
                              },


                              {
                                type: 'submit',
                                placeholder : 'Add'
                              }
                            ],
                            onsuccess: function(data){
                              $('#utility-modal').modal('toggle');
                              http.get(HOST_PATH + 'dashboard/getCurriculumManagement', function(data){

                                for(var element in data.main){
                                  element = new this[element](data.main[element], data.additional);
                                  $('#mainContent').empty().attach(element,'curriculum');

                                }

                                for(var element in data.header){
                                    element = new this[element](data.header[element], data.additional);
                                    $('.content-header').empty().attach(element,'curriculum');
                                }


                              });
                            }
                          };

                          break;

    }


    this.get = function(){
      this.form = new form(this.form);
      return this.form.get();
    }

    this.init = function(id){
      this.form.init();
      $('.scroll').slimScroll({
            size: '3px',
            height: '50vh'
      });
      $('#nestable').nestable({
          group: 1
      });
    }

}

function pathNavBar(data, add = null){
  this.data = data;
  this.additional = add;
  this.markup = ``;
  this.get = function(){

      this.markup += `<div class="header-title">
                        <div class="row">
                          <div class="col-md-1 width-none fs1.5 pl0 pl9">`;
                            if(this.data.length >1)
                              this.markup += `<i class="fa fa-chevron-left pointer pt7 crumb" data-id="`+this.data[this.data.length-2].id+`" style="font-size:1.5em;"></i>`;
                            else
                              this.markup += `<i class="fa fa-chevron-left pointer pt7 crumb" data-id="home" style="font-size:1.5em;"></i>`;
      this.markup +=     `</div>
                          <div class="col-md-11 width98 alt-breadcrumb">

                            <ol class="breadcrumb">
                              <li><a class = "crumb pointer" data-id="home"><i class="pe-7s-home "></i>Home</a></li>`;
                            if(this.data.length>0){
                              for (var i = 0; i < this.data.length-1; i++) {
                                this.markup += `<li class="crumb pointer" data-id="`+this.data[i].id+`">`+this.data[i].name+`</li>`;
                              }
                              this.markup += `<li class="active crumb pointer" data-id="`+this.data[i].id+`">`+this.data[i].name+`-Concept</li>`;
                            }

   this.markup +=  `</ol>
                        </div>
                      </div>
                    </div>`;
    return this.markup;
  }
  this.init = function(){
    $('.crumb').click(function(e){
      var id = $(this).data('id');

      if(id == 'home')
      {
        window.explorer.path = [];
        $('.sidebarItem.active').trigger('click');
        $('.content-header').empty().attach(new pathNavBar(window.explorer.path));
      }
      else {
        var pathIndex = window.explorer.path.findIndex(function(p){
          return p.id == id;
        });
        window.explorer.path = window.explorer.path.slice(0,pathIndex+1);
        http.get(HOST_PATH + 'dashboard/getDir/' + id, function(data){
          $('#mainContent').empty().attach(new explorer(data), id);
          $('.content-header').empty().attach(new pathNavBar(window.explorer.path));
        });
      }
    });
  }
}

function explorer(data, add = null){
  this.data = data;
  this.additional = add;
  this.markup = ``;
  this.get = function(){

    var ownedItems = this.data.topics.filter(function(item){
      console.log(item);
      return item.own;
    });

    var otherItems = this.data.topics.filter(function(item){
      return !item.own;
    });

    this.markup += `<div class="explorer pb47">
    <div class="tool-bar"></div>
    <div class="section">
      <div class="title-break">
        <div class="title"><h4 class="mtb0">Owned</h4></div>
      </div>
      <div class="row">`;

      for(var i=0; i<ownedItems.length; i++){
        var topic = ownedItems[i];
        this.markup += `<div class="col-xs-4 col-sm-3 col-md-3 col-lg-2 explorer-item">

          <a href="#">
          ${topic.own?`<div class="checkbox checkbox-info checkbox-circle explorer-item-cb sneek">
                          <input id="checkbox${topic.id}" type="checkbox" value="${topic.id}" data-type="topic">
                          <label for="checkbox${topic.id}"></label>
                      </div>`:''}
          

            <div class="panel panel-bd subtopic-item" data-id="`+topic.id+`">
              <div class="panel-body pb0">
                <img src="assets/dist/img/subtopic-own.png" width="95%">
                <h5 class="dir-title" title="`+topic.name+`">`+topic.name+`</h5>

              </div>

            </div>
          </a>
        </div>`;
      }

      this.markup +=`</div>
    </div>
    <div class="section">
      <div class="title-break">
        <div class="title"><h4 class="mtb0">Other</h4></div>
      </div>
      <div class="row">`;
      for(var i=0; i<otherItems.length; i++){
        var topic = otherItems[i];
        this.markup += `<div class="col-xs-4 col-sm-3 col-md-3 col-lg-2 explorer-item">

          <a href="#">
          ${topic.own?`<div class="checkbox checkbox-info checkbox-circle explorer-item-cb sneek">
                          <input id="checkbox${topic.id}" type="checkbox" value="${topic.id}" data-type="topic">
                          <label for="checkbox${topic.id}"></label>
                      </div>`:''}
          

            <div class="panel panel-bd ${window.explorer.path.length == 3?'subtopic':'topic'}-item" data-id="`+topic.id+`">
              <div class="panel-body pb0">
                <img src="assets/dist/img/subtopic.png" width="95%">
                <h5 class="dir-title" title="`+topic.name+`">`+topic.name+`</h5>

              </div>

            </div>
          </a>
        </div>`;
      }
      this.markup +=`</div>
    </div>
    </div>`;

    return this.markup;
  }

  this.refresh = function(id){
    if(window.explorer.path.length > 0){
      var itemId  = window.explorer.path[window.explorer.path.length-1].id;
      http.get(HOST_PATH + 'dashboard/getDir/' + itemId, function(data){
        $('#mainContent').empty().attach(new explorer(data), id);
        $('.content-header').empty().attach(new pathNavBar(window.explorer.path));
      });

    }
  }


  this.init = function(id){
    var self = this;
    var selectAllAction = function(){
      $('.explorer-item-cb input[type=checkbox]').each(function(){
        $(this).prop('checked', true).triggerHandler('change');
      });
    };

    var clearAction = function(){
      $('.explorer-item-cb input[type=checkbox]').each(function(){
        $(this).prop('checked', false).triggerHandler('change');
      });
    }

    var newTopicAction = function(){
      var parent = null;
      if(window.explorer.path.length>0){
        parent = window.explorer.path[window.explorer.path.length-1].id;
      }
      $('#sub-modal').find('h1').text('Add Topic');
      $('#sub-modal').find('.modal-body').empty().attach(new form({
        id: 'newCurrForm',
        action: 'dashboard/addNewDir',
        elements:[
          {
            type: 'text',
            name: 'name',
            placeholder: 'Name'
          },
          {
            type: 'hidden',
            name: 'parent',
            value: parent
          },
          {
            type: 'submit',
            placeholder : 'Add'
          }
        ],

        onsuccess: function(data){
          $('#sub-modal').modal('toggle');
          self.refresh();
        }

      }));
      $('#sub-modal').modal('toggle');
    }

    var newSubtopicAction = function () {
      var parent = null;
      if (window.explorer.path.length > 0) {
        parent = window.explorer.path[window.explorer.path.length - 1].id;
      }

      var subtopicdz = new dropzone({
        'url': HOST_PATH + 'dashboard/addDirContent',
        'params': {
          parent: parent
        }
      });
      
      var Quizeditor = new quizEditor({ id: '', title: '', questions: [] });
      var subtopicForm = new form({
        id: 'addNewSubtopicForm',
        action: 'dashboard/addNewSubtopic',
        upload: true,
        elements: [
          {
            type: 'hidden',
            value: parent,
            name: 'parent'
          },
          {
            type: 'text',
            placeholder: 'Name',
            name: 'name'
          },
          {
            type: 'custom',
            markup: subtopicdz.get()
          },
          {
            type: 'custom',
            markup: Quizeditor.get()
          },
          {
            type: 'submit',
            placeholder: 'Save'
          }
        ],
        onsuccess: function (data) {
          mydropzone.options.params = {parent:data};
          mydropzone.processQueue();
        }

      });

      $('#large-modal').find('h1').text('Add Content');
      $('#large-modal').find('.modal-body').empty().attach(subtopicForm);

      $('#large-modal').modal('toggle');
      Quizeditor.init();
      var mydropzone = subtopicdz.init();
      // $('#large-modal').on('hidden.bs.modal', function () {
      //   $('#large-modal').off('hidden.bs.modal');
      //   self.refresh();
      // });

      

      
    }

    var newQuizAction = function(){
      var parent = null;
      if(window.explorer.path.length>0){
        parent = window.explorer.path[window.explorer.path.length-1].id;
      }

      var quizeditor = new quizEditor({id:'', title:'', questions:[]});

      var qeform = new form({
        id: 'addNewQuizForm',
        action: 'dashboard/addNewQuiz',
        elements:[
          {
            type: 'hidden',
            value: parent,
            name: 'parent'
          },

          {
            type: 'custom',
            markup: quizeditor.get()

          },
          {
            type: 'submit',
            placeholder : 'Save'
          }
        ],
        onsuccess: function(data){
          $('#large-modal').modal('toggle');
          self.refresh();
        }

      });

      $('#large-modal').find('.modal-body').empty().attach(qeform);
      quizeditor.init();
      $('#large-modal').modal('toggle');
    }

    var deleteAction = function(){

      swal({
          title: "Are you sure?",
          text: "You will not be able to recover this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel pls!",
          closeOnConfirm: false,
          closeOnCancel: false},
              function (isConfirm) {
                  if (isConfirm) {
                    var topics = [], contents = [];
                    $('.explorer-item-cb input[type=checkbox]:checked').each(function(){
                      if($(this).attr('data-type')== 'topic'){
                        topics.push($(this).val());
                      }
                      else {
                        contents.push($(this).val());
                      }
                    });

                    if(contents.length >0){
                      http.post(HOST_PATH + 'dashboard/deleteDirContent',{contents:contents}, function(data){
                        if(data.success)
                          swal("Deleted!", "Topic is deleted.", "success");
                        else
                        swal({
                            title: "Unauthorised!",
                            text: "Some of the contents may not be deleted.",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "OK",
                            closeOnConfirm: true}
                        );

                        self.refresh();
                      });
                    }
                    if(topics.length>0){
                      http.post(HOST_PATH + 'dashboard/deleteDir', {dir:topics} , function(data){
                        if(data.success)
                          swal("Deleted!", "Topic is deleted.", "success");
                        else
                          swal({
                              title: "Unauthorised!",
                              text: "Some of the contents may not be deleted.",
                              type: "warning",
                              showCancelButton: false,
                              confirmButtonColor: "#DD6B55",
                              confirmButtonText: "OK",
                              closeOnConfirm: true});

                        self.refresh();
                      });
                    }

                  } else {
                      swal("Cancelled", "It is safe :)", "error");
                  }
      });
    }

    var renameAction = function(){
      var url = '', contentId = $('.explorer-item-cb input[type=checkbox]:checked').val();
      if($('.explorer-item-cb input[type=checkbox]:checked').attr('data-type') == 'topic')
        url = 'dashboard/editDir';
      else
        url = 'dashboard/editDirContent';

      $('#small-modal').find('h1').text('Rename Topic');
      $('#small-modal').find('.modal-body').empty().attach(new form({
        id: 'newCurrForm',
        action: url,
        elements:[
          {
            type: 'hidden',
            name: 'id',
            value: contentId
          },
          {
            type: 'text',
            name: 'name',
            placeholder: 'Name',
            value: $('.explorer-item-cb input[type=checkbox]:checked').closest('.explorer-item').find('.dir-title').text()
          },
          {
            type: 'submit',
            placeholder : 'Save'
          }
        ],
        onsuccess: function(data){
          $('#small-modal').modal('toggle');
          self.refresh();
        }

      }));
      $('#small-modal').modal('toggle');
    }

    var toolbarActions = [
      {
        name: 'Select All',
        action: selectAllAction,
        icon: 'check-square-o'
      },
      {
        name: 'Clear',
        action: clearAction,
        icon: 'square-o'
      },
      {
        name: 'Delete',
        action: deleteAction,
        icon: 'close'
      },
      {
        name: 'Rename',
        action: renameAction,
        icon: 'pencil'

      }
    ];

    switch (explorer.path.length) {
      case 0: toolbarActions = toolbarActions.concat([
        {
          name: 'New Module',
          action: newTopicAction,
          icon: 'plus'
        }
      ]);
        console.log(toolbarActions);
        break;

      case 1: toolbarActions = toolbarActions.concat([
        {
          name: 'New Concept',
          action: newTopicAction,
          icon: 'plus'
        }
      ]);
        break;

      case 2: toolbarActions = toolbarActions.concat([
        {
          name: 'New Topic',
          action: newTopicAction,
          icon: 'plus'
        }
      ]);
        break;

      case 3: toolbarActions = toolbarActions.concat([
        {
          name: 'New Subtopic',
          action: newSubtopicAction,
          icon: 'plus'
        }
      ]);

    }

    var toolbar = new toolbarContent(toolbarActions);
    $('.tool-bar').empty().append(toolbar.get());
    toolbar.init();

    $('.explorer-item-cb input[type=checkbox]').change(function() {
      if(this.checked){
        $(this).closest('.explorer-item-cb').removeClass('sneek');
      }
      else {
        $(this).closest('.explorer-item-cb').addClass('sneek');
      }

      var n = $('.explorer-item-cb input:checked').length;



      if (n == 0) {
        $('#tb-Clear').hide();
        $('#tb-Delete').hide();
        $('#tb-Rename').hide();
      }
      else if (n == 1) {
        $('#tb-Clear').show();
        $('#tb-Delete').show();
        $('#tb-Rename').show();
      }
      else {
        $('#tb-Clear').show();
        $('#tb-Rename').hide();
      }




    });

    $('.explorer').click(function(){
      if (event.target == this) {
        clearAction();
      }
    });

    $('.topic-item').click(function(e){
      var itemId = $(this).data('id'), itemName = $(this).find('h5').text();
      http.get(HOST_PATH + 'dashboard/getDir/' + itemId, function(data){
        window.explorer.path.push({id : itemId, name : itemName});
        $('#mainContent').empty().attach(new explorer(data), id);
        $('.content-header').empty().attach(new pathNavBar(window.explorer.path));
      });

    });
    $('.subtopic-item').click(function(e){
      var itemId = $(this).data('id');
      var itemName = $(this).find('h5').text();
      http.get(HOST_PATH + 'dashboard/getDir/' + itemId, function(data){
        var contentRow = new subtopicContentRow(data.content);
        var subtopicdz = new dropzone({
          'url': HOST_PATH + 'dashboard/addDirContent',
          'params': {
            parent: itemId
          }
        });
        
        
        
        var Quizeditor = new quizEditor(data.quiz);

        var subtopicForm = new form({
          id: 'addNewSubtopicForm',
          action: 'dashboard/editSubtopic',
          upload: true,
          elements: [
            {
              type: 'hidden',
              value: itemId,
              name: 'subtopicId'
            },
            {
              type: 'text',
              placeholder: 'Name',
              name: 'name',
              value: itemName
            },
            {
              type: 'custom',
              markup: contentRow.get()
            },
            {
              type: 'custom',
              markup: subtopicdz.get()
            },
            {
              type: 'custom',
              markup: Quizeditor.get()
            },
            {
              type: 'submit',
              placeholder: 'Save'
            }
          ],
          onsuccess: function (data) {
            mydropzone.processQueue();
            console.log(data);
          }
  
        });
  
        $('#large-modal').find('h1').text('Add Content');
        $('#large-modal').find('.modal-body').empty().attach(subtopicForm);
  
        $('#large-modal').modal('toggle');
        contentRow.init();
        Quizeditor.init();
        var mydropzone = subtopicdz.init();
      });

    });

    

  }
}

function subtopicContentRow(data, add=null){
  this.data = data;
  this.additional = add;
  this.markup = ``;
  this.get = function(){
    this.markup += `<div class="form-group"><div class="row">`;
    for(var i=0; i<this.data.length; i++){
        var content = this.data[i];
        this.markup += `
        <input type="hidden" name="contents[]" value="${content.id}">
        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-2 explorer-item">
          <a href="#">
          ${content.own?`<div class="explorer-item-cb sneek cross">
                          <i class="fa fa-times"/>
                        </div>`:''}
          
            <div class="panel panel-bd content-item" data-id="`+content.id+`" data-type="`+content.type+`">
              <div class="panel-body pb0">
                <img src="assets/dist/img/${content.own?content.type+'-own':content.type}.png" width="95%">
                <h5 class="dir-title" title="`+content.name+`">`+content.name+`</h5>
  
              </div>
  
            </div>
          </a>
        </div>`;
    }
    this.markup += `</div></div>`;
    return this.markup;
  }

  this.init = function(){
    $('.explorer-item .cross').click(function(){
      $(this).closest('.explorer-item').remove();
    });
    $('.content-item').click(function(e){
      var itemId = $(this).data('id'),itemType = $(this).data('type'), itemName = $(this).find('h5').text();
      if(itemType == 'webm' || itemType == 'mp4')
      {
        $('#utility-modal').find('.modal-body').empty().append(`
            <video class="video-preview video-js vjs-default-skin" autoplay preload="none" id="player" src="`+HOST_PATH + 'watch?id='+itemId+`" controls width="100%"></video>
          `);

        videojs($('.video-js')[0], {}, function(){});
        $('video').on('contextmenu', function(e) {
            e.preventDefault();
        });
	    $('#utility-modal').modal('toggle');

      }
      else if (itemType == 'pdf') {

        $('#utility-modal').find('.modal-body').empty().append(`
            <div>
              <iframe style="height:80vh" src = "assets/plugins/ViewerJS/#${location.protocol + '//' +location.hostname + HOST_PATH + 'watch?id='+itemId}" width='100%'  allowfullscreen webkitallowfullscreen></iframe>

            </div>
          `);
	    $('#utility-modal').modal('toggle');

      }
      else if (itemType == 'quiz') {
        http.get(HOST_PATH + 'dashboard/getQuiz/'+$(this).data('id'), function(data){

          var quizeditor = new quizEditor(data.quiz);

          var qeform = new form({
            id: 'editQuizForm',
            action: 'dashboard/editQuiz',
            elements:[
              {
                type: 'custom',
                markup: quizeditor.get()

              },
              {
                type: 'submit',
                placeholder : 'Save'
              }
            ],
            onsuccess: function(data){
              $('#large-modal').modal('toggle');

            }

          });

          var response = new dataTable(data.responses);

          $('#utility-modal').find('.modal-body').empty().attach(new tabs({
            names: ['Quiz', 'Responses'],
            content: [qeform, response]
          }));

          quizeditor.init();

          $('#utility-modal').modal('toggle');
        });
      }



    });
  }
}

function toolbarContent(data, add=null){
  this.data = data;
  this.additional = add;
  this.markup =``;
  this.get = function(){
    this.markup += `<ul>`;
    for(var i=0; i<this.data.length; i++){
      this.markup +=    `<li class="pointer dis-inl-block p10" id="tb-${this.data[i].name.replace(' ', '-')}">
                              <i class="fa fa-${this.data[i].icon} fs15"></i>
                              <span class="tool-text">${this.data[i].name}</span>
                         </li>`;
    }
    this.markup += `</ul>`;
    return this.markup;
  }
  this.init = function(id){
    var self = this;
    for(var i=0; i<this.data.length; i++){
      $('#tb-'+this.data[i].name.replace(' ', '-')).click(this.data[i].action);
    }
    $('#tb-Delete').hide();
    $('#tb-Rename').hide();
    $('#tb-Clear').hide();
  }
}


function dropzone(data, add = null){
  this.data = data;
  this.additional = add;
  this.markup =``;
  this.get = function(){
    this.markup +=`<div action="#" class="dropzone dz-clickable" id="myDropzone">


                                                          </div>`;

    return this.markup;
  }
  this.init = function(id){

    var myDropzone = new Dropzone(document.getElementById('myDropzone'),{
      url : this.data.url,
      params: this.data.params,
      maxFilesize: 1024,
      acceptedFiles: ".pdf,.mp4,.webm",
      autoProcessQueue: false

    });
    return myDropzone;

  }
}

function tabs(data, add=null){
  this.data = data;
  this.additional = add;
  this.markup = ``;

  this.get = function(){
    this.markup += `<ul class="nav nav-tabs">`;
    for(var i =0; i<this.data.names.length; i++){
      this.markup += `<li class="${i==0?'active':''}"><a href="#${this.data.names[i].replace(' ', '-')}" data-toggle="tab">${this.data.names[i]}</a></li>`;
    }

    this.markup += `</ul>
        <div class="tab-content">`;

    for(var i =0; i<this.data.content.length; i++){

      this.markup += `<div class="tab-pane fade in ${i==0?'active':''}" id="${this.data.names[i].replace(' ', '-')}">`;



      if(typeof this.data.content[i] === 'object'){
        this.markup += this.data.content[i].get();
      }
      else {
        this.markup += this.data.content[i];
      }

      this.markup += `</div>`;
    }

    this.markup += '</div>';
    return this.markup;
  }

  this.init = function(){
    for(var i =0; i<this.data.content.length; i++){
      if(typeof this.data.content[i] === 'object'){
        this.data.content[i].init();
      }
    }
  }
}





function quizEditor(data, add= null){
  this.data = data;
  this.additional = add;
  this.markup = ``;

  this.get = function(){

    this.markup += `
      <div class="quiz-box mtb10">
                      <div class="form-group">
                        <input type="hidden" class="form-control" name="id"  value = "${this.data.id}">
                      </div>

                      <div class="quiz-questions-box">`;

    for(var i=0; i< this.data.questions.length; i++){
      this.data.questions[i] = new quizQuestion(this.data.questions[i], i);
      this.markup += this.data.questions[i].get();
    }

    this.markup += `</div>
                    <div class="panel panel-bd">
                      <div class="panel-body pointer center p8">
                        <div id="add-question-btn">
                          <label class="pointer">Add Question</label>
                        </div>
                      </div>
                    </div>
                    </div>`;





    return this.markup;
  }


  this.init = function(id){
    var n = $('.quiz-box .question').length;
    $('#add-question-btn').click(function(){
      $('.quiz-questions-box').attach(new quizQuestion({
        id: 'qq' + n,
        type: 'MUL',
        answer: 'null',
        text: '',
        options: ['','','','']
      }, n++));
    });

    for(var i=0; i< this.data.questions.length; i++){
      this.data.questions[i].init();
    }




  }

}

function quizQuestion(data, add=null){
  this.data = data;
  this.additional = add;
  this.markup = ``;
  this.get = function(){
    this.markup += `<div class="panel panel-bd question" data-id="${this.data.id}">
                                    <div class="panel-body">
                                          <div class="row rem-que">
                                              <i class="pe-7s-close pull-right"></i>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <input type="hidden" class="form-control" name="question[${this.additional}][id]"  value = "${this.data.id}">
                                                </div>
                                                <div class="form-group">
                                                          <label for="type-select${this.additional}">Type :</label>
                                                          <select class="form-control type-select" name="question[${this.additional}][type]" id="type-select${this.additional}">
                                                              <option ${this.data.type=='MUL'?'selected':''} value="MUL">Multiple Choice</option>
                                                              <option ${this.data.type=='TF'?'selected':''} value="TF">True or False</option>
                                                              <option ${this.data.type=='SEQ'?'selected':''} value="SEQ">Jumbled Sequence</option>
                                                              <option ${this.data.type=='SA'?'selected':''} value="SA">Short Answer</option>
                                                          </select>
                                                </div>
                                                
                                              </div>
                                              <div class="col-sm-6">
                                                <div class="form-group">
                                                  <label for="question-diag${this.additional}">Diagram :</label>
                                                  <input type="file" name="question[${this.additional}][diagram]" for="question-diag${this.additional}">
                                                </div>
                                              </div>

                                          </div>
                                          <div class="form-group">
                                                  <label for="question${this.additional}">Question :</label>
                                                  <textarea class="form-control" name="question[${this.additional}][text]"  id="question${this.additional}" rows="2" required>${this.data.text}</textarea>
                                          </div>


                                          <div class="question-type-options">`;
    switch (this.data.type) {
      case 'MUL':  this.markup += `<div class="form-group">
                                            <label for="option-select${this.additional}">Number of Options :</label>
                                                <input class="form-control question-option-select" type="number" value="${this.data.options.length}" id="option-select${this.additional}">

                                      </div>
                                      <div class="form-group question-option-group">`;
                  for (var i = 0; i < this.data.options.length; i++) {
                      this.markup +=    `<div>
                                            <div class="radio dis-inl">
                                                <input type="radio" ${this.data.answer == this.data.options[i]?'checked':''} name="question[${this.additional}][correct]" id="option${this.additional + '-' + i}" value="${i}" required>
                                                <label for="option${this.additional + '-' + i}"><input type="text" class="quiz-optn" name="question[${this.additional}][options][${i}]" value="${this.data.options[i]}" placeholder="Option Here" required></label>
                                            </div>
                                            <label for="optionfile${this.additional + '-' + i}"><i class="fa fa-photo pointer"></i></label>
                                            <input type="file" id="optionfile${this.additional + '-' + i}" area-describedby="fileHelp" name="question[${this.additional}][options][${i}]" style="display:none;">
                                        </div>`;
                  }

                  this.markup +=     `</div>`;


                  break;

      case 'TF':  this.markup += `<div class="form-group">
                                          <div>
                                              <div class="radio dis-inl">
                                                  <input type="radio" ${this.data.answer == 'true'?'checked':''} name="question[${this.additional}][correct]" id="option${this.additional + '-' + 1}" value="true" required>
                                                  <label for="option${this.additional + '-' + 1}">True</label>
                                              </div>
                                          </div>
                                          <div>
                                              <div class="radio dis-inl">
                                                  <input type="radio" ${this.data.answer == 'false'?'checked':''} name="question[${this.additional}][correct]" id="option${this.additional + '-' + 2}" value="false" required>
                                                  <label for="option${this.additional + '-' + 2}">False</label>
                                              </div>
                                          </div>
                                      </div>`;



                  break;

      case 'SA':  this.markup += `<div class="form-group">
                                          <label for="answer${this.additional}">Answer :</label>
                                              <input class="form-control" value="${this.data.answer}" name="question[${this.additional}][answer]" type="text" id="answer${this.additional}" required>
                                    </div>`;



                  break;

      case 'SEQ': this.markup += `<div class="form-group">
                                    <label for="statement-select${this.additional}">Number of Statements :</label>
                                    <input class="form-control question-option-select" type="number" value="${this.data.options.length}" id="statement-select${this.additional}">
                                  </div>
                                  <div class="form-group question-option-group">`;
                                  for (var i = 0; i < this.data.options.length; i++) {
                                     this.markup +=    `<div>
                                                             <span>${i+1}.</span>
                                                             <input type="text" class="quiz-optn" name="question[${this.additional}][options][${i}]" value="${this.data.options[i]}" placeholder="Statement Here" required>
                                                        </div>`;
                                  }

                  this.markup +=     `</div>`;
                  break;

    }
    this.markup +=                       `</div>

    </div>
                                </div>
                                `;

    return this.markup;
  }

  this.init = function(id){
    var self = this;

    $('.rem-que').click(function(){
      $(this).closest('.question').remove();
    });

    $('#option-select' + self.additional).change(function(){
      var n = parseInt(this.value);
      $(this).closest('.question').find('.question-option-group').empty();
      for (var i = 0; i < n; i++) {
        $(this).closest('.question').find('.question-option-group').append(`
          <div>
              <div class="radio dis-inl">
                  <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + i}" value="${i}" required>
                  <label for="option${self.additional + '-' + i}"><input type="text" class="quiz-optn" name="question[${self.additional}][options][${i}]" placeholder="Option Here" required></label>
              </div>
              <label for="optionfile${self.additional + '-' + i}"><i class="fa fa-photo pointer"></i></label>
              <input type="file" id="optionfile${self.additional + '-' + i}" area-describedby="fileHelp" name="question[${self.additional}][options][${i}]" style="display:none;">
          </div>
          `);
      }
    });
    

    $('#statement-select' + self.additional).change(function(){
      var n = parseInt(this.value);
      $(this).closest('.question').find('.question-option-group').empty();
      for (var i = 0; i < n; i++) {
        $(this).closest('.question').find('.question-option-group').append(`
        <div>
          <span>${i+1}.</span>
          <input type="text" class="quiz-optn" name="question[${self.additional}][options][${i}]" value="${self.data.options[i]}" placeholder="Statement Here" required>
        </div>
        `);
      }
    });

    $('.type-select').change(function(){
      switch (this.value) {
        case 'MUL': var typeOptions = `<div class="form-group">
                                              <label for="option-select${self.additional}">Number of Options :</label>
                                                  <input class="form-control question-option-select" type="number" value="4" id="option-select${self.additional}">

                                        </div>
                                        <div class="form-group question-option-group">
                                            <div>
                                                <div class="radio dis-inl">
                                                    <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + 1}" value="${0}" required>
                                                    <label for="option${self.additional + '-' + 1}"><input type="text" class="quiz-optn" name="question[${self.additional}][options][0]" placeholder="Option Here" required></label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="radio dis-inl">
                                                    <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + 2}" value="${1}" required>
                                                    <label for="option${self.additional + '-' + 2}"><input type="text" class="quiz-optn" name="question[${self.additional}][options][1]" placeholder="Option Here" required></label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="radio dis-inl">
                                                    <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + 3}" value="${2}" required>
                                                    <label for="option${self.additional + '-' + 3}"><input type="text" class="quiz-optn" name="question[${self.additional}][options][2]" placeholder="Option Here" required></label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="radio dis-inl">
                                                    <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + 4}" value="${3}" required>
                                                    <label for="option${self.additional + '-' + 4}"><input type="text" class="quiz-optn" name="question[${self.additional}][options][3]" placeholder="Option Here" required></label>
                                                </div>
                                            </div>
                                        </div>`;

                    $(this).closest('.question').find('.question-type-options').empty().append(typeOptions);
                    $('#option-select' + self.additional).change(function(){
                      var n = parseInt(this.value);
                      $(this).closest('.question').find('.question-option-group').empty();
                      for (var i = 0; i < n; i++) {
                        $(this).closest('.question').find('.question-option-group').append(`
                          <div>
                              <div class="radio dis-inl">
                                  <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + i}" value="${i}" required>
                                  <label for="option${self.additional + '-' + i}"><input type="text" class="quiz-optn" name="question[${self.additional}][options][${i}]" placeholder="Option Here" required></label>
                              </div>
                              <label for="optionfile${self.additional + '-' + i}"><i class="fa fa-photo pointer"></i></label>
                              <input type="file" id="optionfile${self.additional + '-' + i}" area-describedby="fileHelp" name="question[${self.additional}][options][${i}]" style="display:none;">
                          </div>
                          `);
                      }
                    });
                    
                
                    
                    break;

        case 'TF':  var typeOptions = `<div class="form-group">
                                            <div>
                                                <div class="radio dis-inl">
                                                    <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + 1}" value="true" required>
                                                    <label for="option${self.additional + '-' + 1}">True</label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="radio dis-inl">
                                                    <input type="radio" name="question[${self.additional}][correct]" id="option${self.additional + '-' + 2}" value="false" required>
                                                    <label for="option${self.additional + '-' + 2}">False</label>
                                                </div>
                                            </div>
                                        </div>`;

                    $(this).closest('.question').find('.question-type-options').empty().append(typeOptions);

                    break;

        case 'SA':  var typeOptions = `<div class="form-group">
                                            <label for="answer${self.additional}">Answer :</label>
                                                <input class="form-control" name="question[${self.additional}][answer]" type="text" id="answer${self.additional}" required>
                                      </div>`;

                    $(this).closest('.question').find('.question-type-options').empty().append(typeOptions);

                    break;

        case 'SEQ': var typeOptions = `<div class="form-group">
                                           <label for="statement-select${self.additional}">Number of Statements :</label>
                                          <input class="form-control question-option-select" type="number" value="4" id="statement-select${self.additional}">
                                       </div>
                                       <div class="form-group question-option-group">
                                         <div>
                                            <span>1.</span>
                                            <input type="text" class="quiz-optn" name="question[${self.additional}][options][0]" placeholder="Statement Here" required>
                                         </div>
                                         <div>
                                            <span>2.</span>
                                            <input type="text" class="quiz-optn" name="question[${self.additional}][options][1]" placeholder="Statement Here" required>
                                         </div>
                                         <div>
                                            <span>3.</span>
                                            <input type="text" class="quiz-optn" name="question[${self.additional}][options][2]" placeholder="Statement Here" required>
                                         </div>
                                         <div>
                                            <span>4.</span>
                                            <input type="text" class="quiz-optn" name="question[${self.additional}][options][3]" placeholder="Statement Here" required>
                                         </div>
                                       </div>`;

                     $(this).closest('.question').find('.question-type-options').empty().append(typeOptions);
                     $('#statement-select' + self.additional).change(function(){
                      var n = parseInt(this.value);
                      
                      $(this).closest('.question').find('.question-option-group').empty();
                      for (var i = 0; i < n; i++) {
                        $(this).closest('.question').find('.question-option-group').append(`
                        <div>
                          <span>${i+1}.</span>
                          <input type="text" class="quiz-optn" name="question[${self.additional}][options][${i}]" value="${self.data.options[i]}" placeholder="Statement Here" required>
                        </div>
                        `);
                      }
                    }); 
                     break;


      }
    });
  }
}

function quiz(data, add= null){
  this.data = data;
  this.additional = add;
  this.markup = ``;
  this.currentIndex = 0;
  this.get = function(){
    this.markup +=`<div class="panel panel-bd quiz-container">
                    <form method="POST" action="${this.data.submitURL}">
                      <div class="question-container">
                        
                      </div>`;



    this.markup +=`
                      <button type="submit" class="btn btn-primary pull-right quiz-btn mt0 mb0 finish-btn">Next</button>
                    </form>
                  </div>`;

    return this.markup;
  }



  this.getQuestionMarkup = function(){
    var self = this;
    $('.quiz-container .question-container').empty();

    http.get(this.data.fetchURL, function(data){
      if(data != false && data != null){
        var questionMarkup = '';
        switch(data.type){
          case 'MUL' :questionMarkup +=`<div class="row quiz-row-style quiz-question">
                                                  <h3>${data.text}</h3>
                                                  <div class="center">
                                                      <img src="${data.diagram}"></img>
                                                  </div>
                                                  <div class="row">`;

                                        for (var j = 0; j <data.options.length; j++) {
                                        questionMarkup +=`<input type="hidden" class="form-control" name="question"  value = "${data.id}">
                                          <div class="col-md-6">

                                            <div class="radio dis-inl-block">
                                                  <input type="radio" name="answer" id="radio${j+1}" value="${data.options[j].text}" required>
                                                  <label for="radio${j+1}">${data.options[j].text}</label>
                                            </div>
                                            <img src="${data.options[j].diagram}"></img>
                                        </div>`;
                                        }
                                        questionMarkup +=` </div>
                                        </div>`;
                      break;

          case 'TF':  questionMarkup +=`<div class="row quiz-row-style">
                                                  <h3>${data.text}</h3>
                                                  <img src="${data.diagram}"></img>

                                                  <div class="row">
                                                      <input type="hidden" class="form-control" name="question"  value = "${data.id}">
                                                      <div class="col-md-6">
                                                                        <div class="radio">
                                                                              <input type="radio" name="answer" id="radio${'_T'}" value="true" required>
                                                                              <label for="radio${'_T'}">True</label>
                                                                        </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                                        <div class="radio">
                                                                              <input type="radio" name="answer" id="radio${'_F'}" value="false" required>
                                                                              <label for="radio${'_F'}">False</label>
                                                                        </div>
                                                      </div>
                                                  </div>
                                        </div>`;
                      break;

          case 'SA' : questionMarkup +=`<div class="row quiz-row-style">
                                                    <h3>${data.text}</h3>
                                                    <img src="${data.diagram}"></img>
                                                    <input type="hidden" class="form-control" name="question"  value = "${data.id}">
                                                    <h3 class="dis-inl">Ans.</h3>
                                                    <input type="text" name="answer" class="quiz-optn" required>
                                          </div>`;
                      break;

          case 'SEQ' :questionMarkup +=`<div class="row quiz-row-style">
                                          <h3>${data.text}</h3>
                                          <input type="hidden" class="form-control" name="question"  value = "${data.id}">
                                          <div class="right mb10">
                                              <span class="label label-pill label-primary pointer" id="sortable-reset-btn"><i class="refresh-btn glyphicon glyphicon-refresh"></i>RESET</span>
                                          </div>
                                          <ul id="sortable" class="p0">`;
                                          for (var j = 0; j <data.options.length; j++) {
                                            questionMarkup += `<li class="jum-seq-li" id="statement-${data.options[j].id}"><span class="jum-seq-li-text">${data.options[j].text}</span></li>`;
                                          }
                       questionMarkup += `</ul>
                                        </div>`;
                      break;
        }
        
        $('.quiz-container .question-container').empty().append(questionMarkup);
        $('#sortable').sortable();
        $('#sortable').disableSelection();
        $('#sortable-reset-btn').click(function(){
            $( "#sortable" ).sortable( "cancel" );
        });
        
      }
      else{
        self.onfinish();
      }
      
    });




  }

  this.changeSource = function(fetch, submit){
    this.data.fetchURL = fetch;
    this.data.submitURL = submit;


  }

  this.on = function(event, task){
    this['on'+event] = task;
  }

  this.init = function(id){
    var self = this;
    if(self.data.type == 'foreign'){
      $('.quiz-container form').off().on('submit', function(e){
        e.preventDefault();
        var data = $(this).serialize() +'&'+ $( "#sortable" ).sortable( "serialize", { key: "sequence[]" } );
        console.log(`submitting on ${self.data.submitURL}`, data);
        http.post(self.data.submitURL, data, self.onsuccess);
        $(this).trigger('reset');
      });
    }


  }


}


//FINDER >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

function durationFlyout(data, add= null){
  this.data = data;
  this.additional =add;
  this.markup = ``;

  this.get = function(){

    return this.markup;
  }

  this.init = function(id){


  }

  this.fly = function(){

  }
}

function finderElement(data, add= null){
  this.data = data;
  this.additional = add;
  this.markup = ``;

  this.get = function(){
    this.markup += `<li class="finder-element" data-id="${this.data.id}" data-parent="${this.additional.parent}">
                              <div class="dis-inl-flex">
                                <div class="checkbox checkbox-primary dis-inl-block m0">
                                    <input id="checkbox${this.data.id}" value="${this.data.id}" name="dir[]" type="checkbox">
                                    <label for="checkbox${this.data.id}"></label>
                                </div>
                                <span class="pointer finder-element-name">${this.data.name}</span>
                              </div>
                              <div class="pull-right">
                                  <span class="duration-flyout pointer">${this.data.duration == undefined?'2w':this.data.duration.value + this.data.duration.unit.toLowerCase().charAt(0)}</span>
                                  <i class="fa fa-caret-right pl5 fs1-3"></i>
                              </div>
                          </li>`;
                      // ${this.data.duration.value + this.data.duration.unit.toLowerCase().charAt(0)}
    return this.markup;
  }

  this.init = function(id){
    var self = this;
    var thisElement = $('.finder-element[data-id='+this.data.id+']');



    if(finder.selection.includes(this.data.id.toString())){
      thisElement.find('#checkbox'+this.data.id).prop('checked', true);
    }

    thisElement.find('.duration-flyout').click(function(){
      alert('popup');
    });

    thisElement.find('.finder-element-name').click(function(){
      thisElement.siblings().removeClass('active');
      thisElement.addClass('active');
      $(this).closest('.finder-window').nextAll().remove();
      var finderElement = $(this).closest('.finder');
      var id = $(this).closest('.finder-element').attr('data-id');
      http.get(HOST_PATH + 'dashboard/getDir/' + id, function(data){


        finderElement.attach(new finderWindow(data.topics, {parent: self.data.id}));


      });
      $(".finder").animate({ scrollLeft: $('.finder').width() }, 500);
    });

    thisElement.find('#checkbox'+this.data.id).click(function(){
      var item = $(this).closest('.finder-element');
      var id  = item.attr('data-id'),
      parent = item.attr('data-parent'),
      duration = item.attr('data-duration'),
      unit = item.attr('data-unit');
      if(this.checked){
          finder.collectItem({id,duration,unit}, parent, []);
        //self.additional.onSelected(self.data.id, true);
        finder.selection.push($(this).closest('.finder-element').attr('data-id'));
        // $(this).closest('.finder-window').nextAll().each(function(){
        //   $(this).find('input[type=checkbox]').each(function(){
        //     finder.selection.push($(this).closest('.finder-element').attr('data-id'));
        //     $(this).prop('checked', true);
        //   });
        // });
      }
      else{
        window.finderdata = finder.format(finder.removeItem(id, window.finderdata));
        console.log(window.finderdata);
        //self.additional.onSelected(self.data.id, false);
        finder.selection.splice(finder.selection.indexOf($(this).closest('.finder-element').attr('data-id')),1);
        // $(this).closest('.finder-window').prevAll().find('.finder-element.active').find('input[type=checkbox]').prop('checked', false);
        // $(this).closest('.finder-window').nextAll().each(function(){
        //   $(this).find('input[type=checkbox]').each(function(){
        //     finder.selection.splice(finder.selection.indexOf($(this).closest('.finder-element').attr('data-id')),1);
        //     $(this).prop('checked', false);
        //   });
        // });
      }



    });


  }

}

function finderWindow(data, add = null){
  this.data = data;
  this.additional = add;
  this.markup = ``;
  this.elements = [];
  this.selection = [];


  this.get = function(){
    this.markup += `<div class="finder-window">
                        <ul class="finder-list">`;

    for(var i=0; i<this.data.length; i++){
      this.elements.push(new finderElement(this.data[i], {
        parent: this.additional.parent,
        onSelected: (id, isSelected)=>{
          if(isSelected){
            this.selection.push(id);
            // if(this.selection.length == this.elements.length && this.additional.parent!= null){
            //   $('.finder-element[data-id='+this.additional.parent+'] input[type=checkbox]').trigger('click');
            // }
          }
          else{
            this.selection.splice(this.selection.indexOf(id),1);
          }

          console.log(this.selection);
        }
      }
    ));
      this.markup += this.elements[i].get();
    }

    this.markup +=      `</ul>
                    </div>`;
    return this.markup;
  }

  this.init = function(id){
    for(var i=0; i<this.elements.length; i++){
      this.elements[i].init();
    }

  }
}

function finder(data, add=null){
  this.data = data;
  this.additional = add;
  this.durationFlyout = new durationFlyout({});
  this.windows = [];
  this.markup = ``;
  this.selection = [];

  this.get = function(){
    this.markup += `<div class="finder">`;

    for(var i =0 ; i<this.data.length; i++){
      this.windows.push(new finderWindow(this.data[i], {
        parent: null,
        onSelected: (parent, data, isSelected)=>{
          console.log(this.getSelection(parent,data));
        }
      }));
      this.markup += this.windows[i].get();
    }

    this.markup += `</div>`;
    return this.markup;
  }

  this.init = function(id){
    finder.selection = [];
    window.finderdata = {};
    for(var i =0 ; i<this.windows.length; i++){
      this.windows[i].init();
    }
  }

  finder.collectItem = function(item, parent, data){
    var grandparent = $('.finder-element[data-id='+parent+']').attr('data-parent');
    var id = parent,
    parent = $('.finder-element[data-id='+id+']'),
    duration = parent.attr('data-duration'),
    unit = parent.attr('data-unit');


    if(item.id != null && item.id!= 'null'){
      data.push(item);
      finder.collectItem({id, duration, unit}, grandparent, data);
    }
    else{
      var d = null;
      for(var i = 0; i<data.length; i++){
        var temp = {};
        temp[data[i].id] = {duration: data[i].duration, unit : data[i].unit, children:d};
        d= temp;
      }
      window.finderdata = mergeObjects(window.finderdata, d);
      console.log(window.finderdata);

    }
  }
  finder.removeItem = function(id, parent){
    for(var key in parent){
      if(id == key){
        delete parent[key];
      }
      else{
        if(typeof(parent[key]== 'Object')){
          parent[key] = finder.removeItem(id, parent[key]);
        }
      }

    }

    return parent;
  }
}


finder.format = function(parent){
  let toCheck = false;
  if(Object.keys(parent).length == 0){
    parent = null;
  }
  else{
    for(var key in parent){
      if(parent[key] != null){
        var formated = finder.format(parent[key]);
        if(formated === true){
          if(Object.keys(parent).length == 0){
            parent = null;
            return true;
          }
        }
      }
    }
  }
  return parent;
}

function responses(data, add = null){
  this.data = data;
  this.additional = add;
  this.markup = ``;

  this.get = function(){
    this.markup +=`<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 p0 response-user-list">
      <div class="panel panel-bd h90">
                    <div class="panel-body scroll">`;
    for (var i = 0; i < data.length; i++) {
      this.markup += `<div class="inbox-item pointer response-user-item" data-id="${this.data[i].id}">
                        <div class="inbox-item-img"><img src="assets/dist/img/user.jpg" class="img-circle" alt=""></div>
                          <strong class="inbox-item-author">${this.data[i].name}</strong>
                          <p class="inbox-item-text">${this.data[i].username}</p>
                        </div>
                    `;
    }
    this.markup += `</div>
      </div>

    </div>
    <div class="col-xs-12 col-md-8 col-sm-8 p0 responses">
        <div class="panel panel-bd">
            <div class="panel-body response-box h90 scroll">

            </div>
        </div>
    </div>
  </div>`;

    return this.markup;
  }

  this.init = function(){
    $('.scroll').slimScroll({
      size: '3px',
      height: '90vh'
    });
    $('.response-user-item').click(function(){
      $('.response-user-item.user-response-active').removeClass('user-response-active');
      $(this).addClass('user-response-active');
      $('.response-box').empty();
      var usrId = $(this).attr('data-id');
      http.get('/lms/dashboard/getStudentQuizResponses/'+usrId, function(data){
        var tabledata = [];
        for (var i = 0; i < data.length; i++) {
          tabledata.push([
            data[i].name,
            data[i].score
          ]);
        }
        $('.response-box').attach(new dataTable({
          name: 'response-list',
          noOfTabs: null,
          noOfColumns: 2,
          columnNames: ['Quiz Name', 'Score'],
          data: tabledata
        }, false));
      });
    });
  }
}

function nothing(data, add= null){
  this.get = function(){

  }

  this.init = function(){

  }

}


function mergeObjects(foo, bar) {
    for (var key in bar) {
      if(foo!=null){
        if(foo.hasOwnProperty(key) && bar[key] != null)
          foo[key] = mergeObjects(foo[key], bar[key]);

        else{
          foo[key] = bar[key];
        }
      }
      else{
        foo = bar;
      }

    }

    return foo;

}


function courseView(data, add= null){
  this.data = data;
  this.additional = add;
  this.markup = '';


  this.get = function(){

    this.markup+= `<div class="course-view" data-id="${this.data.id}">
      <div class="text-center course-title">
          <h1>${this.data.name}</h1><p>Course Description Here</p>
      </div>
      <h4 class="student-dashboard-heading">Modules</h4>



      <ul class="module-container">`;

      for(var i=0; i<this.data.modules.length; i++){
        var module = this.data.modules[i];
        this.markup+= `<li class="module-item" data-id="${module.id}">
          <div class="module-content">
            <div class="panel panel-bd">
              <div class="panel-body">
                <div class="row">
                  <h3 class="module-title">${module.name}</h3>
                  <span class="label label-pill label-default-outline m-r-15">Duration: _ Weeks</span>
                </div>
              </div>

              <ul class="topic-container">`;

              for(var j=0; j<module.topics.length; j++){
                var topic = module.topics[j];
                this.markup+= `<li class="topic-item" data-id="${topic.id}" data-curr="${topic.curr}">
                    <div class="row">
                      <span>${topic.name}</span>
                    </div>
                </li>`
              }

              this.markup+= `<li class="topic-test-item" data-id="${module.id}" data-curr="${topic.curr}" style="background:aqua;cursor:pointer">
                  <div class="row">
                      Test
                  </div>
              </li>`;

              this.markup+=`</ul>



              <div class="topic-container-toggler">

                <div class="text-center">
                  <i class="fa fa-angle-left angle-down fs20"></i>
                </div>
              </div>
            </div>
          </div>

        </li>`
      }



      this.markup += `</ul>

    </div>`;


    return this.markup;
  }

  this.init = function(){
    $('.topic-containter').css('max-height', '0');
    $('.topic-container-toggler').click(function(){
      $(this).prev().toggle(
        function(){
          $(this).css('max-height', '0');
        },
        function(){
          $(this).css('max-height', '100vh');
        }
      );
    });

    $('.course-view .topic-item').click(function(){
      var encodedName = $(this).find('span').text().replace(" ", "_");
      window.location.href = `classroom/topic/${encodedName}/${$(this).attr('data-curr')}/${$(this).attr('data-id')}`;
    });

    $('.course-view .topic-test-item').click(function(){
      window.location.href = `classroom/test/4/2`;
    });
  }

}


function tutor(data, add = null){
  this.data = data;
  this.additional = add;
  this.markup = ``;
  this.quiz = null;

  this.get = function(){
    this.markup = ``;
    this.markup += `<div class="tutor">
                      <div class="tutor-media">
                        <video class="video-player video-js vjs-default-skin" preload="none" id="player" src="" data-index="0" controls width="100%"></video>
                      </div>
                      <div class="tutor-mock">


                      </div>
                    </div>`;
    return this.markup;
  }

  this.on = function(event, task){
    this['on'+event] = task;
  }

  this.init = function(){
    var self = this;
    $('.tutor-mock').hide();
    this.quiz = new quiz({fetchURL:this.data.questionFetchURL, submitURL: this.data.questionSubmitURL, type:'foreign'});
    this.quiz.on('success', function(data){
      if(data)
        self.quiz.getQuestionMarkup();
      else{
        alert('Learn and try again.');
        $('.tutor-mock').hide();
        $('.tutor-media').show();
        $('.tutor video')[0].play();
      }

    });

    this.quiz.on('finish', function(){
      self.onfinish();   
    });

    $('.tutor .tutor-mock').attach(this.quiz);


    videojs($('.video-js')[0], {}, function(){});
    videojs('player').ready(function(){
        var player = this;
        player.on('ended', function() {
          $('.tutor-media').hide();
          $('.tutor-mock').show();
          self.quiz.getQuestionMarkup();
        });
    });
    $('video').on('contextmenu', function (e) {
        e.preventDefault();
    });
  }

  

  this.changeMedia = function(video, question){
    this.data.videoFetchURL = video;
    this.data.questionFetchURL = question.fetchURL;
    this.data.questionSubmitURL = question.submitURL;
    this.quiz.changeSource(question.fetchURL, question.submitURL);
    $('.tutor video').attr('src',video);
  }



}
