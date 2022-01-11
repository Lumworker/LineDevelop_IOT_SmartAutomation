<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Customer_Package.aspx.cs" Inherits="IOTSmartAutomation.Customer_Package" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <style>
        .form-control {
            min-width: 100%;
        }
    </style>
    <div class="page-header">
        <h2>Customer Package</h2>
        <div class="row" style="margin-top:1em;">
            <div class="form-group col-md-5 col-sm-6 col-xs-12">
                <asp:Label ID="Label7" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Customer : "></asp:Label>
                <div class="col-md-9 col-xs-12">
                    <div class="input-group">
                        <input type="text" id="txtCustomer_code" class="form-control" disabled style="display:none"/>
                        <input type="text" id="txtCustomer" class="form-control" disabled />
                        <div class="input-group-btn">
                            <button id="buttonModalCustomer" class="btn btn-default" type="button">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-group">
        <!--panel-default-->
        <div class="panel panel-default" style="margin-top: 1em;display:none" id="divDataTable">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6" style="text-align: left;">
                    </div>

                    <div class="col-md-6" style="text-align: right">
                        <button id="btnModalAdd" class="btn btn-success " type="button" data-toggle="modal" style="float: right">Add </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tableCustomer_Package" style="max-width: 100%" class="table table-hover table-bordered table-responsive center">
                            <thead>
                                <tr>
                                    <th>Package Code</th>
                                    <th>Package Name</th>
                                    <th>Active Date</th>
                                    <th>Expire Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="ListPackage">
                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--panel-body-->
        </div>
        <!--panel-default-->
    </div>
    <!--Panel-Group -->

    <div class="modal fade" id="ModalListCustomer" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Detail Machine</h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">

                    <table id="EM_TableCustomer" class="table table-bordered table-responsive">
                        <thead id="Thead2" runat="server">
                            <tr>
                                <th>Customer No</th>
                                <th>Customer Name</th>
                            </tr>
                        </thead>
                        <tbody id='ListCustomer'>
                            <tr>
                                <td><a href="javascript:void(0)" class="ClickSelectLineCustomer" data-dismiss="modal">TH10104</a></td>
                                <td><a href="javascript:void(0)" class="ClickSelectLineCustomer" data-dismiss="modal">บริษัท วรภัทร จำกัด</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalPackage" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                            <div class="col-md-7 col-sm-12">
                                <h4 class="modal-title"><span id="TitleModalPackage"></span>: Package</h4>
                            </div>
                            <div class="col-md-5 col-sm-12" style="text-align: right;">
                                <button type="button" class="btn btn-success" id="SavePackage">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height: 28em; max-width: 100%;">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1em; display: none">
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
                                    <div class="input-group">
                                        <input type="text" id="text_PackageCode" class="form-control" style="min-width: 100%" autocomplete="off" disabled />
                                        <div class="input-group-btn">
                                            <button class="btn btn-default Browse_modal" type="button" id="btnBrowsePackage" data-type="PackageCode">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1em;">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label" style="font-size: 13px">Active Date :</label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="text_Active_date" class="form-control " style="min-width: 100%" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1em;">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label" style="font-size: 13px">Expire Date :</label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="text_Expire_date" class="form-control " style="min-width: 100%" autocomplete="off" />
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

    <div class="modal fade" id="modalBrowseSearch" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xs" id="modalSize">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 id="Titlebrowse" class="modal-title">Text</h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form-group col-md-12 col-lg-12 col-sm-12">
                            <div id="search_box">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height: 28em; max-width: 100%;">
                    <table id="TbListBrowse" class="table table-striped table-bordered table-responsive">
                        <thead>
                            <tr class="header" id="TBheaderBrowse">
                                <%-- <th>Column</th>
                                <th>Name</th>
                                <th></th>--%>
                            </tr>
                        </thead>
                        <tbody id='TBbodyBrowse'></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <%--modalBrowseSearch--%>

    <script>
        $(document).ready(function () {
            SetDatePicker();

            var tableCustomer_Package = $("#tableCustomer_Package").DataTable({
                searching: false,
                responsive: true,
                "order": []
            });

            $("#buttonModalCustomer").on('click', function () {
                CallCustomer();
            });

            $(document).on("click", "#btnModalAdd", function () {
                $("#btnBrowsePackage").prop('disabled', false)
                $("#TitleModalPackage").text('Add');
                $("#text_Status").val('Insert');
                $("#text_PackageCode").val('');
                $("#text_Active_date").val('');
                $("#text_Expire_date").val('');
                $("#ModalPackage").modal("show");
            });

            $(document).on("click", ".btnModalEdit", function () {
                $("#btnBrowsePackage").prop('disabled', true)
                var row = $(this).closest("tr");
                var PackageCode =row.find("td:nth-child(1)").text();
                var PackageName =row.find("td:nth-child(2)").text();
                var Active_date =row.find("td:nth-child(3)").text();
                var Expire_date =row.find("td:nth-child(4)").text();
                $("#TitleModalPackage").text('Edit');
                $("#text_Status").val('Update');
                $("#text_PackageCode").val(PackageCode);
                $("#text_Active_date").val(Active_date);
                $("#text_Expire_date").val(Expire_date);
                $("#ModalPackage").modal("show");
            });

            $(document).on("change", "#search_PackageCode", function () {
                let search = $(this).val();
                Get_PackageCode(search);
            });

            $(document).on("click", "#SavePackage", function () {
                let customer_no = $("#txtCustomer_code").val();
                let PackageCode = $("#text_PackageCode").val();
                let Active_date = $("#text_Active_date").val();
                let Expire_date = $("#text_Expire_date").val();
                let Status = $("#text_Status").val();
                SP_Customer_Package(customer_no, PackageCode, Active_date, Expire_date, Status)
            });

            $(document).on("click", ".Browse_modal", function () {
                var Type = $(this).attr("data-type");
                $("#Titlebrowse").text(Type);
                $("#TBbodyBrowse").empty();
                $("#TBheaderBrowse").empty();
                $("#search_box").empty();
                $("#search_box").append('<input type="text" id="search_' + Type + '" placeholder="Search.." class="form-control max-wide" autocomplete="off">');
                if (Type == 'PackageCode') {
                    Get_PackageCode('');
                    $("#modalBrowseSearch").modal("show");
                }//End JobTitle

            });
            //End ModalBrowseSearch


            $(document).on('click', '.ClickSelectLineCustomer', function () {
                var row = $(this).closest("tr");
                let Customer_code = row.find("td:nth-child(1)").text();
                let Customer = row.find("td:nth-child(2)").text();
                $("#txtCustomer_code").val(Customer_code);
                $("#txtCustomer").val(Customer);
                $('#ModalListCustomer').modal('hide');
                $('#divDataTable').css("display", "");
                GetTable(Customer_code);
            });
            $(document).on("click", ".clickselecttext_Package", function () {
                var tr = $(this).closest("tr");
                var Package_code = tr.find("td:nth-child(1)").text();
                var Package_name = tr.find("td:nth-child(2)").text();
                $("#text_PackageCode").val(Package_code);
                $("#modalBrowseSearch").modal("hide");
            });


            function CallCustomer() {
                $("#ListCustomer").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListCustomer") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({}),
                    success: function (response) {
                        var frament = "";
                        $.each(response.d, function (index, val) {
                            var Code = val[0];
                            var Name = val[1];
                            frament += '<tr>';
                            frament += '<td><a href="javascript:void(0)" class="ClickSelectLineCustomer">' + Code + '</a></td>';
                            frament += '<td><a href="javascript:void(0)" class="ClickSelectLineCustomer">' + Name + '</a></td>';
                            frament += '</tr>';
                        });
                        $("#ListCustomer").append(frament);
                        $('#ModalListCustomer').modal('show');
                    }
                });
            }

            function Get_PackageCode(search) {
                $("#Titlebrowse").text('Search Package');
                $("#TBheaderBrowse").empty();
                $("#TBbodyBrowse").empty();
                var fragmentHeader = '';
                var fragment = '';
                let notin = ""

                var rows = tableCustomer_Package.$("tr");
                let i_count_HavePackage = 0;
                rows.each(function () {
                    var Package_Code = $(this).find("td:nth-child(1)").text();
                    if (Package_Code != "") {
                        if (i_count_HavePackage == 0) {
                            notin += "'"+Package_Code+"'";
                        } else {
                            notin += ",'"+Package_Code+"'";
                        }
                        i_count_HavePackage++
                    }
                });
                //Set Notin
                $("#modalSize").attr('class', 'modal-dialog modal-md');
                fragmentHeader = `<th>Package Code</th>
                                     <th>Package Code</th>`;
                $.ajax({
                    type: "post",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GET_Customer_Package") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ notin:notin ,search:search}),
                    success: function (response) {
                        if (response.d.length > 0) {
                            $.each(response.d, function (index, val) {
                                var PackageCode = val[0];
                                var PackageName = val[1];
                                fragment += '<tr>';
                                fragment += '<td><a class="clickselecttext_Package" href="javascript:void(0)">' + PackageCode + '</a></td>';
                                fragment += '<td><a class="clickselecttext_Package" href="javascript:void(0)">' + PackageName + '</a></td>';
                                fragment += '</tr>';
                            });
                        }
                    }
                });
                $("#TBheaderBrowse").append(fragmentHeader);
                $("#TBbodyBrowse").append(fragment);
            }


            function GetTable(customer_no) {
                $("#IMGUpload").modal("show");
                tableCustomer_Package.clear().draw();
                $.ajax({
                    type: "post",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GET_VW_Customer_Package") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ customer_no: customer_no }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            $.each(response.d, function (index, val) {
                                var customer_no = val[0];
                                var PackageCode = val[1];
                                var PackageName = val[2];
                                var Active_date = val[3];
                                var Expire_date = val[4];
                                tableCustomer_Package.row.add([
                                    PackageCode,
                                    PackageName,
                                    Active_date,
                                    Expire_date,
                                    '<td><button class="btn btn-warning  btnModalEdit" type="button" >Edit</button></td>'
                                    //'<td><button class="btn btn-danger  btnDelete" type="button" >Delete</button></td>'
                                ]).draw(false);
                            });
                        }
                        $("#IMGUpload").modal("hide");
                    }
                });
            }

            function SP_Customer_Package(customer_no, PackageCode, Active_date, Expire_date, Status) {
               if (customer_no != "" &&PackageCode != "" && Active_date !=""&& Expire_date !=""&& Status !="") {
                    $.ajax({
                        type: "post",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_Customer_Package") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify({
                            customer_no: customer_no, PackageCode: PackageCode, Active_date: Active_date
                            , Expire_date:Expire_date, Status:Status
                        }),
                        success: function (response) {
                            var Msg = response.d;
                            swal("บันทึกรายการเสร็จสิ้น", "", "success")
                            GetTable(customer_no)
                            $("#ModalPackage").modal("hide");
                        }

                    });
                } else {
                    swal('Error', 'กรุณากรอกข้อมูลให้ครบถ้วน', 'error');
                }
            }


            function SetDatePicker() {
                $('#text_Active_date').datepicker({ format: "dd/mm/yyyy", autoclose: true });
                $('#text_Expire_date').datepicker({ format: "dd/mm/yyyy", autoclose: true });
            }




        });


    </script>
</asp:Content>
