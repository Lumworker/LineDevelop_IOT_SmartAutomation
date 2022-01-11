<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="RawDataMaster.aspx.cs" Inherits="IOTSmartAutomation.RawDataMaster" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">

    <style>
        .form-control {
            min-width: 100%;
        }
    </style>

    <div class="page-header">
        <h2>Rawdata Master
            <button class="btn btn-success" type="button" id="btnModalAddRawData">Add </button>
        </h2>
    </div>
    <div class="panel-group">
        <div class="panel panel-default" style="margin-top: 1em;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableRawdataMaster">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Group</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="ListRawdataMaster">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--END Table-->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalAddRawDataMaster" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
                            <h4 class="modal-title">RawData</h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label6" class="col-md-4 col-xs-12" runat="server" Font-Bold="True" Text="RawData Code : "></asp:Label>
                            <div class="col-md-8 col-xs-12">
                                <input type="text" id="txtRawdataMasterCode" class="form-control" placeholder="RawData Master Code"  disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row" id="DisplayRawDataType">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label2" class="col-md-4 col-xs-12" runat="server" Font-Bold="True" Text="RawData Group : "></asp:Label>
                            <div class="col-md-8 col-xs-12">
                                <select class="form-control" id="txtRawDataMasterGroup">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label1" class="col-md-4 col-xs-12" runat="server" Font-Bold="True" Text="RawData Name : "></asp:Label>
                            <div class="col-md-8 col-xs-12">
                                <input type="text" id="txtRawDataMasterName" class="form-control" placeholder="RawData Master Name" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddRawdataMaster" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            GetRawDataList();


            $(document).on('click', '#btnModalAddRawData', function () {
                $("#DisplayRawDataType").show();
                $("#txtRawdataMasterCode").val("").attr("data-typeclick", "Insert");
                $("#txtRawDataMasterName").val("");
                GetMachineGroup();
                $("#btnAddRawdataMaster").html("Add");
                $("#ModalAddRawDataMaster").modal("show");
            });
            $(document).on('click', '.btnModalRawdataMaster', function () {
                var txtRawdataMasterCode = $(this).closest("tr").find("td:nth-child(1)").text();
                var txtRawDataMasterName = $(this).closest("tr").find("td:nth-child(3)").text();
                var txtRawDataMasterGroup = $(this).closest("tr").find("td:nth-child(1)").text().charAt(3);
                $("#DisplayRawDataType").val(txtRawDataMasterGroup);
                $("#DisplayRawDataType").hide();
                $("#txtRawdataMasterCode").val(txtRawdataMasterCode).attr("data-typeclick", "Edit");
                $("#txtRawDataMasterName").val(txtRawDataMasterName);
                $("#btnAddRawdataMaster").html("Save");
                $("#ModalAddRawDataMaster").modal("show");
            });

            $("#btnAddRawdataMaster").on('click', function () {
                var typeclick = $("#txtRawdataMasterCode").attr("data-typeclick");
                var txtRawDataMasterName = $("#txtRawDataMasterName").val();
                var txtRawDataMasterGroup = $("#txtRawDataMasterGroup").val();
                var txtRawdataMasterCode = $("#txtRawdataMasterCode").val() != "" ? $("#txtRawdataMasterCode").val() : txtRawDataMasterGroup;
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_RawData_mst") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ rawdata_ID: txtRawdataMasterCode, rawdata_name: txtRawDataMasterName, rawdata_group: txtRawDataMasterGroup ,  type: typeclick }),
                    success: function (response) {
                        GetRawDataList();
                        alert("Save Complete");
                        $("#ModalAddRawDataMaster").modal("hide");
                    }
                });
            });
            
            $(document).on('click', '.btnDeleteRawdataMaster', function () {
                if (confirm("Confirm Delete RawData??")) {
                    var row = $(this).closest("tr");
                    var txtRawdataMasterCode = row.find("td:nth-child(1)").text();
                    var txtRawDataMasterName = row.find("td:nth-child(2)").text();
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_RawData_mst") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify({ rawdata_ID: txtRawdataMasterCode, rawdata_name: txtRawDataMasterName, rawdata_group: 0 , type: "Delete" }),
                        success: function (response) {
                            row.remove();
                            alert("Delete Complete");
                        }
                    });
                }
            });

            function GetRawDataList() {
                $("#ListRawdataMaster").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListRawData_mst") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({}),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            $.each(response.d, function (index, val) {
                                var Code = val[0];
                                var Name = val[1];
                                var group = val[0].charAt(3);
                                if (group == 1) {
                                    group = 'Compressor';
                                }
                                else if(group == 2) {
                                    group = 'EvaporativeCondenser';
                                }
                                else if(group == 3) {
                                    group = 'PlateIce';
                                }
                                else if(group == 4) {
                                    group = 'Production';
                                }
                                else if(group == 5) {
                                    group = 'Other';
                                }
                                frament += '<tr>';
                                frament += '<td style="width: 20%;">' + Code + '</td>';
                                frament += '<td style="width: 20%;">' + group + '</td>';
                                frament += '<td style="width: 20%;">' + Name + '</td>';
                                frament += '<td><button type="button" class="btn btn-warning btn-block btnModalRawdataMaster">Edit</button></td>';
                                //frament += '<td><button type="button" class="btn btn-danger btn-block btnDeleteRawdataMaster">Delete</button></td></tr>';
                                frament += '</tr>';
                            });
                            $("#ListRawdataMaster").append(frament);
                        }
                    }
                });
            }

            function GetMachineGroup() {
                $("#txtRawDataMasterGroup").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListMachine_group") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ Type: "" }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            $.each(response.d, function (index, val) {
                                var frament = "";
                                var ID = val[0];
                                var Name = val[1];
                                var Name_Group = val[2];
                                frament += '<option value="' + ID + '">' + Name_Group + '</option>';

                                $("#txtRawDataMasterGroup").append(frament);
                            });
                        }
                    }
                });
            }

        });

    </script>

</asp:Content>
