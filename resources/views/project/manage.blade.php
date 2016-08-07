@extends ('master.master')
@section ('content')

<div class="left_col" role="main" style="color:black">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-size:40px"> My Project Idea!</h3>
      </div>

      <div class="modal fade bs-example-modal-sm"  tabindex="-1" role="dialog" aria-hidden="true" id="del-modal">
        <div class="modal-dialog modal-sm" >
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel2">Delete Your Project?</h4>
            </div>
            <div class="modal-body">
              <p>Deleting Your project will permanently remove it from your account and will not be recorded in your history</p>
              <p>Are you sure?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <a  class="btn btn-danger button_modal" >Delete</a>
            </div>

          </div>
        </div>
      </div>
     
    </div>
    <div class="row">
      <div class="col-md-12 ">
        <div class="x_panel">
          <div class="x_title">
            <a  class="btn btn-primary" href="{{url('project/create')}}"><i style = "color:white" class="fa fa-plus"></i> Add New Project</a>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr >
                  <th width="5%" class="text-center">No</th>
                  <th width="20%" class="text-center">Nama Project</th>
                  <th width="5%" class="text-center">Status</th>
                  <th class="text-center" width="15%">Mentor</th>
                  <th class="text-center" width="15%">Sponsor</th>
                  <th class="text-center" width="5%">Budget Plan</th>
                  <th class="text-center" width="10%">Start Date</th>
                  <th class="text-center" width="10%">End Date</th>
                  <th class="text-center" width="15%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach ($projects as $project)
                <tr>
                  <td>{{++$i}}</td>
                  <td>{{$project->namaproject}}</td>
                  @if($project->status == 0)
                    <td>Pending</td>
                  @elseif($project->status == 1)
                    <td>Approved</td>
                  @endif
                  <td>{{$project->mentor}}</td>
                  <td>{{$project->sponsor->nama}}</td>
                  <td class="text-center"><a href="{{URL::to('budget/'.$project->budgetperkiraan)}}" data-toggle="tooltip" title="Download" class = "btn btn-primary" download><i style = "color:white" class="fa fa-download"></i></a></td>
                  <td></td>
                  <td></td>
                  <td class="text-center">
                    <a href="{{URL::to('project/update/'.$project->id)}}" class="btn btn-success" data-toggle="tooltip" title="Update"><i class="fa fa-pencil"></i></a>
                    @if ($project->status == 0)
                      <button onclick="dele('{{url('project/delete/'.$project->id)}}')" class="btn btn-danger" data-toggle="modal" data-target="#del-modal" title="Delete"><i class="fa fa-trash"></i></button>
                    @endif
                </td>
                </tr> 
                @endforeach
              </tbody>
            </table>

        
          </div>
        </div>
      </div>
    </div>
    

@endsection

@section ('custom_foot')
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'){
        echo '<script language="javascript">';
            echo 'swal("Berhasil!", "Data berhasil ditambahkan!", "success");';
            echo '</script>';
      }
    ?>
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
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'){
        echo '<script language="javascript">';
            echo 'swal("Berhasil!", "Data berhasil ditambahkan!", "success");';
            echo '</script>';
      }
    ?>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'delete-success'){
        echo '<script language="javascript">';
            echo 'swal("Berhasil!", "Data berhasil dihapus!", "success");';
            echo '</script>';
      }
    ?>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'update-success'){
        echo '<script language="javascript">';
            echo 'swal("Berhasil!", "Data berhasil diupdate!", "success");';
            echo '</script>';
      }
    ?>

    <!-- /Datatables -->
    <script type="text/javascript">
      function dele(id){
            $('#modaldiv').modal('show');
            $('.button_modal').attr({href:id});
      };
    </script>
@endsection        
