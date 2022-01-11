<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Package.aspx.cs" Inherits="IOTSmartAutomation.Package" %>
<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
     <style>
        .max-wide {
            max-width: 100%;
        }

        .datepicker {
            background: #333;
            border: 1px solid #555;
            color: #EEE;
        }

        .nav-tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }
    </style>
    <div class="page-header">
        <div class="row">
            <div class="col-md-6" style="text-align: left;">
            <h2>Package</h2>
            </div>

            <div class="col-md-6" style="text-align: right">
                <%--<button id="btnModalNew" class="btn btn-info" type="button" data-toggle="modal">New </button>--%>
                <button id="btnModalNew" class="btn btn-success " type="button" data-toggle="modal" style="float: right">New </button>
            </div>
        </div>
    </div>

    <div class="panel-group">
        <!--panel-default-->
        <div class="panel panel-default" style="margin-top: 1em;" id="divDataTable">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div >
                            <table class="table table-hover table-bordered table-responsive center" style="width: 100%" id="tablePackage">
                                <thead>
                                    <tr>
                                        <th>Package Code</th>
                                        <th>Package Name</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="ListPackage">
                                    <%--<tr>
                                        <td>A</td>
                                        <td>Tube Ice</td>
                                        <td><button class="btn btn-warning  btnModalEdit" type="button" >Edit</button></td>
                                        <td><button class="btn btn-danger  btnDelete" type="button" >Delete</button></td>
                                    </tr>--%>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--panel-body-->
        </div>
        <!--panel-default-->
    </div>
    <!--Panel-Group -->

     <div class="modal fade" id="ModalPackage" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em; ">
                        <div class="col-md-7 col-sm-12">
                            <h4 class="modal-title"><span id="TitleModalPackage"></span> : Package</h4>
                        </div>
                        <div class="col-md-5 col-sm-12" style="text-align: right;">
                            <button type="button" class="btn btn-success" id="SavePackage" >Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height: 28em; max-width: 100%;">
                    
                    <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1em;display:none">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label class="control-label" style="font-size: 13px">Status :</label>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="text_Status" class="form-control " style="min-width: 100%" autocomplete="off" disabled />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1em;">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label class="control-label" style="font-size: 13px">Package Code :</label>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="text_PackageCode" class="form-control " style="min-width: 100%" autocomplete="off" disabled />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1em;">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label class="control-label" style="font-size: 13px">Package Name :</label>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="text_PackageName" class="form-control " style="min-width: 100%" autocomplete="off" disabled />
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <%--Browse New/Edit--%>
    

    <script>
        $(document).ready(function () {


            var tablePackage = $("#tablePackage").DataTable({
                searching: true,
                responsive: true,
                "order": []
            });
            GetTable();

            $(document).on("click", "#btnModalNew", function () {
                $("#TitleModalPackage").text('New');
                $("#text_Status").val('Insert');
                $("#text_PackageCode").val('');
                $("#text_PackageName").val('');
                $( "#text_PackageCode" ).prop( "disabled", false );
                $( "#text_PackageName" ).prop( "disabled", false );
                $("#ModalPackage").modal("show");
            });


            $(document).on("click", ".btnModalEdit", function () {
                var PackageCode =  $(this).closest("tr").find("td:nth-child(1)").text();
                var PackageName =  $(this).closest("tr").find("td:nth-child(2)").text();
                $("#TitleModalPackage").text('Edit');
                $("#text_Status").val('Update');
                $("#text_PackageCode").val(PackageCode);
                $("#text_PackageName").val(PackageName);
                $( "#text_PackageCode" ).prop( "disabled", true  );
                $( "#text_PackageName" ).prop( "disabled", false );
                $("#ModalPackage").modal("show");
            });


            $(document).on("click", ".btnDelete", function () {
                var PackageCode = $(this).closest("tr").find("td:nth-child(1)").text();
                var PackageName = $(this).closest("tr").find("td:nth-child(2)").text();
                //confirm
                swal({
                    title: 'ยืนยันการลบข้อมูล',
                    text: "",
                    icon: 'info',
                    buttons: {
                        cancel: true,
                        confirm: true,
                    },
                }).then(function (confirm) {
                    if (confirm) {
                        SP_Package(PackageCode, PackageName, 'Delete');
                    }
                })

            });


            $(document).on("click", "#SavePackage", function () {
                var PackageCode =  $("#text_PackageCode").val();
                var PackageName =  $("#text_PackageName").val();
                var Status =  $("#text_Status").val();
                SP_Package(PackageCode,PackageName,Status)
            });

            function GetTable() {
                $("#IMGUpload").modal("show");
                tablePackage.clear().draw();
                $.ajax({
                    type: "post",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GET_TB_Package") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            $.each(response.d, function (index, val) {
                                //[ID],[Tag_Group],[Charge1],[Charge2],[Charge3][TagGroupName],[MainType]
                                var PackageCode = val[0];
                                var PackageName = val[1];
                                tablePackage.row.add([
                                    PackageCode,
                                    PackageName,
                                    '<td><button class="btn btn-warning  btnModalEdit" type="button" >Edit</button></td>',
                                    '<td><button class="btn btn-danger  btnDelete" type="button" >Delete</button></td>'
                                ]).draw(false);
                            });
                        }
                        $("#IMGUpload").modal("hide");
                    }
                });
            }

            function SP_Package(PackageCode,PackageName,Status) {
               if (PackageCode != "" && Status !="") {
                    console.log(PackageCode)
                    console.log(PackageName)
                    console.log(Status)
                    $.ajax({
                        type: "post",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_Package") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify({
                            PackageCode: PackageCode, PackageName: PackageName, Status: Status
                        }),
                        success: function (response) {
                            var Msg = response.d;
                            swal("บันทึกรายการเสร็จสิ้น", "", "success")
                            GetTable()
                            $("#ModalPackage").modal("hide");
                        }

                    });
                } else {
                    swal('Error', 'กรุณากรอกข้อมูลให้ครบถ้วน', 'error');
                }
            }

        });
        //End Ready

    </script>
</asp:Content>
