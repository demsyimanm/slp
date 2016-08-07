@extends ('master.master')
@section ('content')

<div class="left_col" role="main" style="color:black">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-size:30px"><i class="fa fa-plus-square"></i> Add Your New Project Idea</h3>
      </div>
     <script src="{{URL::to('assets/ckeditor/ckeditor.js')}}"></script>    
    </div>
    <div class="row">
      <div class="col-md-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>My Project Idea Form</h2>
            
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <form id = "form" class="form-horizontal form-label-left" novalidate action="" method="POST" enctype="multipart/form-data">
              

              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Project Title <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="project_name" name="namaproject" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

            

              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Project Background<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="alasan" name="alasan" required="required" class="form-control col-md-7 col-xs-12" style="height: 100px"></textarea>
                </div>
              </div>

              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Project Plan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="deskripsi" name="deskripsi" required="required" class="form-control col-md-7 col-xs-12" style="height: 100px"></textarea>
                </div>
              </div>

              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Strategic Intention <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="intention" name="intention" required="required" class="form-control col-md-7 col-xs-12" style="height: 100px"></textarea>
                </div>
              </div>

              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Mentor <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="mentor" name="mentor" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

           
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sponsor<span class="required">*</span>
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="sponsor_id">
                    @foreach($mentors as $mentor)
                      <option value="{{$mentor->id}}">{{$mentor->nama}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Budget Plan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <input class="form-control" type="file" name="datafile" >
                </div>
              </div>

              
              <div class="clearfix"></div>
              <div class="x_title" style="margin-top:5%">
                <h2>Human Resource Needed</h2>
                
                <div class="clearfix"></div>
              </div>
              <div>
                <input type="hidden" id="sumOfGoods" name="sumOfGoods" value="0">
                <div id="hr">
                  <!--div class="col-md-12 item form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" >Person 1 <span class="required">*</span></label>
                    <div class="item col-md-10">
                      <div class="item form-group col-md-6">
                        <div class="col-md-12">
                          <center><span><b>Job Spesification</b><span class="required">*</span></center>
                          <div class="x_content">
                            <textarea name="js1" id="js1"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="item form-group col-md-6">
                        <div class="col-md-12">
                          <center><span><b>Job Description</b><span class="required">*</span></center>
                          <div class="x_content">
                            <textarea name="jd1" id="jd1"></textarea>
                          </div>
                        </div>
                      </div>
                    </div-->
                    <!--script type="text/javascript">
                      for (var i = 1; i <= 2; i++) {
                        CKEDITOR.replace( 'js'+i );
                      };
                    </script-->
                  </div>
                </div>
                <div class="col-md-2">
                  <a class="btn btn-primary" style="float:right" id="addRow">Add New Person</a>
                </div>
              </div>


              <div class="clearfix"></div>
              <div class="x_title" style="margin-top:3%">
                <h2>Timeline</h2>
                <div class="clearfix"></div>
              </div>
              <div>
                <div class="col-md-12 item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" >Progress Monitoring 1 <span class="required">*</span></label>
                  <div class="item form-group col-md-3">
                  </div>
                  <div class="item form-group col-md-8">
                    <div class="col-md-9">
                      <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="reservation1" id="reservation" class="form-control"  />
                      </div>
                      <span> What need to be done?<span class="required">*</span>
                      <div class="x_content">
                        <textarea name="descr1" id="descr_1"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div>
                <div class="col-md-12 item form-group" >
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" >Progress Monitoring 2 <span class="required">*</span></label>
                  <div class="item form-group col-md-3">

                  </div>
                  <div class="item form-group col-md-8">
                    <div class="col-md-9">
                      <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="reservation2" id="reservation2" class="form-control"  />
                      </div>
                      <span> What need to be done?<span class="required">*</span>
                      <div class="x_content">
                        <textarea name="descr2" id="descr_2" required="required" style="display:none;" > </textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div>
                <div class="col-md-12 item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" >Progress Monitoring 3 <span class="required">*</span></label>
                  <div class="item form-group col-md-3">

                  </div>
                  <div class="item form-group col-md-8">
                    <div class="col-md-9">
                      <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="reservation3" id="reservation3" class="form-control"  />
                      </div>
                      <span> What need to be done?<span class="required">*</span>
                      <div class="x_content">
                        <textarea name="descr3" id="descr_3" required="required" style="display:none;" > </textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div>
                <div class="col-md-12 item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" >Progress Monitoring 4 <span class="required">*</span></label>
                  <div class="item form-group col-md-3">

                  </div>
                  <div class="item form-group col-md-8">
                    <div class="col-md-9">
                      <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="reservation4" id="reservation4" class="form-control"  />
                      </div>
                      <span> What need to be done?<span class="required">*</span>
                      <div class="x_content">
                        <textarea name="descr4" id="descr_4" required="required" style="display:none;" > </textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  {{csrf_field()}}
                  <!-- <button type="submit" class="btn btn-primary">Cancel</button> -->
                  <div class="btn btn-success"  id="send">Submit</div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <script type="text/javascript">
      CKEDITOR.replace( 'descr_1' );
    </script>
    <script type="text/javascript">
      CKEDITOR.replace( 'descr_2' );
    </script>
    <script type="text/javascript">
      CKEDITOR.replace( 'descr_3' );
    </script>
    <script type="text/javascript">
      CKEDITOR.replace( 'descr_4' );
    </script>
    <script type="text/javascript">
          
    </script>
@endsection

@section ('custom_foot')

    <script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'right',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };

        $('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#reportrange_right').daterangepicker(optionSet1, cb);

        $('#reportrange_right').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange_right').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange_right').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });

        $('#options1').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
        });

        $('#options2').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
        });

        $('#destroy').click(function() {
          $('#reportrange_right').data('daterangepicker').remove();
        });

      });
    </script>

    <script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        $('#single_cal1').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal3').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_3"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal4').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- bootstrap-wysiwyg -->
    <!-- /bootstrap-wysiwyg -->

    <script>
      $(document).ready(function() {
        $('#reservation').daterangepicker(null, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /validator -->
    <script>
      $(document).ready(function() {
        $('#reservation2').daterangepicker(null, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /validator -->
    <script>
      $(document).ready(function() {
        $('#reservation3').daterangepicker(null, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /validator -->
    <script>
      $(document).ready(function() {
        $('#reservation4').daterangepicker(null, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <script type="text/javascript">
      function sendData(){
        swal({
          title: "Data Sedang Diproses",   
          text: "Mohon tidak menutup halaman ini.",   
          imageUrl: "{{URL::to('img/loading.gif')}}",
          showConfirmButton: false
        });

        $( "#form" ).submit();
      }

      $( "#send" ).click(function() {
        swal({   
          title: "Apakah Anda Yakin ?",   
          type: "warning",   showCancelButton: true,   
          confirmButtonColor: "#6BDD55",   
          confirmButtonText: "Yes",   
          closeOnConfirm: false }, 
          function(){   
            sendData();
          });
      });

    </script>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'){
        echo '<script language="javascript">';
            echo 'swal("Berhasil!", "Data berhasil ditambahkan!", "success");';
            echo '</script>';
      }
    ?>
    
  <script type="text/javascript">
    var arr = [];
    var i = 1;
        $('#addRow').click(function(){

          var target = $('#hr');
          var div_utama = $(document.createElement('div')).attr({id:"row"+i});
            var button = $(document.createElement('button')).addClass('btn btn-danger col-md-1').attr({id:"del"+i}).attr({value:i}).attr({onclick : "removeRow(this)"}).html('Remove');
            var label = $(document.createElement('label')).addClass('control-label col-md-1 ').attr({});
              var konten_div1 = $(document.createElement('p')).html('Person '+i+' *').attr({id:"person"+i});
            var div = $(document.createElement('div')).addClass('item col-md-9');
              var div2 = $(document.createElement('div')).addClass('item form-group col-md-6');
                var div3 = $(document.createElement('div')).addClass('col-md-12');
                  var center1 = $(document.createElement('center'));
                    var b1 = $(document.createElement('b')).html('Job Spesification *');
                  var div4 = $(document.createElement('div')).addClass('x_content');
                    var textarea1 = $(document.createElement('textarea')).attr({id:"js"+i, name:"js"+i});
              var div2_2 = $(document.createElement('div')).addClass('item form-group col-md-6');
                var div3_2 = $(document.createElement('div')).addClass('col-md-12');
                  var center1_2 = $(document.createElement('center'));
                    var b1_2 = $(document.createElement('b')).html('Job Description *');
                  var div4_2 = $(document.createElement('div')).addClass('x_content');
                    var textarea1_2 = $(document.createElement('textarea')).attr({id:"jd"+i, name:"jd"+i});


          div4.append(textarea1);
          center1.append(b1);
          div3.append(center1);
          div3.append(div4);
          div2.append(div3);

          div4_2.append(textarea1_2);
          center1_2.append(b1_2);
          div3_2.append(center1_2);
          div3_2.append(div4_2);
          div2_2.append(div3_2);

          div.append(div2);
          div.append(div2_2);

          label.append(konten_div1);

          div_utama.append(button);
          div_utama.append(label);
          div_utama.append(div);

          target.append(div_utama);
          /*$("#del"+i).click(function(){
              $("#row"+i).remove();
              i--;
              $("#sumOfGoods").val(i);
          });*/
          CKEDITOR.replace( 'js'+i );
          CKEDITOR.replace( 'jd'+i );
          $("#sumOfGoods").val(i);
          i++;
    });
</script>
<script type="text/javascript">
    removeRow = function(del){
        var z = $(del).val();
        var temp_sum = $("#sumOfGoods").val();
        temp_sum--;
        $("#row"+z).remove();

        if (i > z)
        {
            var temp_i = i;
            var temp_z = z;
            var temp_index = i;
            for (x = temp_z; x<temp_i;x++)
            {
                temp_index = x-1;
                $("#row"+x).attr({id:"row"+temp_index});
                $("#person"+x).html("Person "+temp_index).attr({id:"person"+temp_index});
                $("#del"+x).attr({id:"del"+temp_index}).attr({id:"del"+temp_index}).attr({value:temp_index});
                $("#js"+x).attr({name:"js"+temp_index}).attr({id:"js"+temp_index});
                $("#jd"+x).attr({name:"jd"+temp_index}).attr({id:"jd"+temp_index});
            }
        }
        i--;

        $("#sumOfGoods").val(temp_sum);
    }
</script>
@endsection        
