<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="RawDataMaster.aspx.cs" Inherits="IOTSmartAutomation.RawDataMaster" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">

    <style>
        .form-control {
            min-width: 100%;
        }
    </style>

    <div class="page-header">
        <h2>Rawdata Master</h2>
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
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="ListRawdataMaster">
                                    <tr id="LineAddRawdataMaster">
                                        <td>
                                            <input type="text" id="txtRawdataMasterCode" class="form-control" placeholder="Rawdata Master Code" disabled/></td>
                                        <td>
                                            <input type="text" id="txtRawdataMasterName" class="form-control" placeholder="Rawdata Master Name" /></td>
                                        <td>
                                            <button type="button" id="btnAddRawdataMaster" class="btn btn-success btn-block">Add</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--END Table-->
                </div>
            </div>
        </div>
    </div>


    <script>

        $(document).ready(function () {
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
                            frament += '<tr>';
                            frament += '<td><input class="form-control" type="text" value="' + Code + '" disabled/></td>';
                            frament += '<td><input class="form-control" type="text" value="' + Name + '"/></td>';
                            frament += '<td><button type="button" class="btn btn-warning btn-block btnUpdateRawdataMaster">Save</button></td>';
                            frament += '<td><button type="button" class="btn btn-danger btn-block btnDeleteRawdataMaster">Delete</button></td></tr>';
                            frament += '</tr>';
                        });
                         $("#ListRawdataMaster").append(frament);
                    }
                }
            });

            $("#btnAddRawdataMaster").on('click', function () {
                var txtRawdataMasterName = $("#txtRawdataMasterName").val();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_RawData_mst") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ rawdata_ID: "", rawdata_name: txtRawdataMasterName, type: "Insert" }),
                    success: function (response) {
                        var frament = "";
                        frament += '<tr>';
                        frament += '<td><input class="form-control" type="text" value="' + response.d + '" disabled/></td>';
                        frament += '<td><input class="form-control" type="text" value="' + txtRawdataMasterName + '"/></td>';
                        frament += '<td><button type="button" class="btn btn-warning btn-block btnUpdateRawdataMaster">Save</button></td>';
                        frament += '<td><button type="button" class="btn btn-danger btn-block btnDeleteRawdataMaster">Delete</button></td></tr>';
                        frament += '</tr>';
                        $("#ListRawdataMaster").append(frament);
                        $("#txtRawdataMasterName").val("");
                        alert("Add Complete");
                    }
                });
            });


            $(document).on('click', '.btnUpdateRawdataMaster', function () {
                var row = $(this).closest("tr");
                var txtRawdataMasterCode = row.find("td:nth-child(1)").find("input").val();
                var txtRawdataMasterName = row.find("td:nth-child(2)").find("input").val();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_RawData_mst") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ rawdata_ID: txtRawdataMasterCode, rawdata_name: txtRawdataMasterName, type: "Edit" }),
                    success: function (response) {
                        alert("Update Complete");
                    }
                });
            });

            $(document).on('click', '.btnDeleteRawdataMaster', function () {
                if (confirm("Confirm Delete RawData??")) {
                    var row = $(this).closest("tr");
                    var txtRawdataMasterCode = row.find("td:nth-child(1)").find("input").val();
                    var txtRawdataMasterName = row.find("td:nth-child(2)").find("input").val();
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_RawData_mst") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify({ rawdata_ID: txtRawdataMasterCode, rawdata_name: txtRawdataMasterName, type: "Delete" }),
                        success: function (response) {
                            row.remove();
                            alert("Delete Complete");
                        }
                    });
                }
            });


        });

    </script>

</asp:Content>
