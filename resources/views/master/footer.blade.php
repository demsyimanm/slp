	  <script src="{{URL::to('gentelella/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{URL::to('gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{URL::to('gentelella/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{URL::to('gentelella/vendors/nprogress/nprogress.js')}}"></script>
    <!-- validator -->
    <script src="{{URL::to('gentelella/vendors/validator/validator.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{URL::to('gentelella/build/js/custom.min.js')}}"></script>

    <!-- validator -->
    <script>
      // initialize the validator function
      validator.message.date = 'not a real date';

      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
      $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          submit = false;
        }

        if (submit)
          this.submit();

        return false;
      });
    </script>
     <!-- bootstrap-daterangepicker -->
    <script src="{{URL::to('assets/moment/moment.min.js')}}"></script>
    <script src="{{URL::to('assets/datepicker/daterangepicker.js')}}"></script>
    <!-- Ion.RangeSlider -->
    <script src="{{URL::to('gentelella/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js')}}"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="{{URL::to('gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/google-code-prettify/src/prettify.js')}}"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="{{URL::to('gentelella/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
    <!-- jquery.inputmask -->
    <script src="{{URL::to('gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <!-- jQuery Knob -->
    <script src="{{URL::to('gentelella/vendors/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- Cropper -->
    <script src="{{URL::to('gentelella/vendors/cropper/dist/cropper.min.js')}}"></script>

    <!-- sweetalert -->
    <script src="{{URL::to('assets/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Custom Theme Scripts -->
    

    <!-- daterange -->
    <!-- Datatables -->
    <script src="{{URL::to('gentelella/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/datatables.net-scroller/js/datatables.scroller.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{URL::to('gentelella/vendors/pdfmake/build/vfs_fonts.js')}}"></script>


    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
    <script src="{{URL::to('assets/ckeditor/ckeditor.js')}}"></script>
    <script src="{{URL::to('gentelella/build/js/custom.min.js')}}"></script>
