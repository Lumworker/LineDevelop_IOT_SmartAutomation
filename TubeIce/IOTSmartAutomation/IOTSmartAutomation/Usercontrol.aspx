<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Usercontrol.aspx.cs" Inherits="IOTSmartAutomation.Usercontrol" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">


    <style>
        .vertical-divider {
            border-right: thin solid #e2e2e2;
            width: 50%;
        }

        .other-half {
            float: right;
            width: 48%;
            height: auto;
            top: 6%;
            right: -2%;
            position: absolute;
        }

        .input-group .form-control {
            width: 85%;
        }

        #registerForm > div > input {
            width: 65% !important;
        }

        @media all and (min-width:593px) {
            .vertical-divider {
                height: 280px;
            }
        }

        @media all and (max-width:593px) {
            .vertical-divider {
                width: 100%;
                border-bottom: thin solid #e2e2e2;
                border-right: 0px;
                padding-top: 15px;
                padding-bottom: 15px
            }

                .vertical-divider > .btn {
                    margin-bottom: 2%;
                }

            .other-half {
                width: 100%;
                float: left;
                position: relative;
                right: 0;
            }
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-sm-11">
            </div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-success btnAddUser" data-toggle="modal" style="margin-top: 10px; margin-bottom: 10px; text-align: right;">Add</button>
            </div>
        </div>
    </div>

    <table id="TableUsercontrol" class="table table-striped table-bordered" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th>User</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="Userdata">
        </tbody>
        <tfoot>
            <tr>
                <th>User</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
            </tr>
        </tfoot>
    </table>


    <!-- The Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Profile</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="vertical-divider">

                                <input type="hidden" id="txtusername">

                                <span>Phone number</span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" id="txtphone" placeholder="Phone number">
                                </div>
                                <br>
                                <span>Email:</span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-at"></i></span>
                                    <input type="text" class="form-control" id="txtEmail" placeholder="Email">
                                </div>
                                <br>
                                <span>Username:</span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-alt"></i></span>
                                    <input type="text" class="form-control" id="txtname" placeholder="Firstname">
                                </div>
                                <br>
                                <span>Lastname:</span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-alt"></i></span>
                                    <input type="text" class="form-control" id="txtLastname" placeholder="Lastname">
                                </div>

                            </div>

                            <div class="other-half">

                                <span>Usertoken:</span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                    <input type="text" class="form-control" id="Usertoken" disabled placeholder="Usertoken">
                                </div>
                                <br>
                                <button class="btn btn-danger ResetToken">
                                    <i class="fas fa-undo"></i>
                                    Reset Token                               
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class="col-md-6" style="margin: auto; width: 60%; padding: 10px;">
                                    <span>Status:</span>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-shield-alt"></i></span>
                                        <select id="Status" class="form-control">
                                            <option>Active</option>
                                            <option>InActive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveUser" class="btn btn-success" data-action="">Confirm</button>
                </div>
            </div>
        </div>

    </div>


    <script>

        
        $(document).ready(function () {
             var TableUsercontrol = $('#TableUsercontrol').DataTable(
                {
                    searching: true,
                    responsive: true
                }
            );
            Call();

            $("#btnSaveUser").on('click', function () {
                if (($("#txtusername").val().length > 0)) {
                    var username = ($("#txtusername").val());
                    //Update
                }
                else {
                    var username = ($("#txtphone").val());
                    //Insert
                }
                $("#txtphone").val();
                var phone = $("#txtphone").val();
                var email = $("#txtEmail").val();
                var name = $("#txtname").val();
                var lastname = $("#txtLastname").val();
                var Status = $("#Status").val();
                var Type = $("#btnSaveUser").attr("data-action");

                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Usercontrol") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ username: username, name: name, lastname: lastname, phone: phone, email: email, Status: Status, Type: Type }),
                    success: function (response) {
                        if (Type == "Insert") {
                            alert("Add Complete");
                        } else if (Type == "Edit") {
                            alert("Edit Complete");
                        }
                        $("#txtusername").val("");
                        $("#txtphone").val("");
                        $("#txtEmail").val("");
                        $("#txtname").val("");
                        $("#txtLastname").val("");
                        $("#Status").val("");
                        $("#myModal").modal("hide");
                        $('tbody').empty();
                        Call();
                    },
                    error: function () {
                        alert("error");

                    }

                });
            });
            
                
            function Call() {
                TableUsercontrol.clear().draw();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetUsercontrol") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(),
                    success: function (response) {
                        if (response.d.length > 0) {
                            $.each(response.d, function (index, val) {
                                var username = val[0];
                                var name = val[1];
                                var lastname = val[2];
                                var email = val[3];
                                var phone = val[4];
                                var Status = val[5];
                                var lineToken = val[6]
                                
                                  var rows = TableUsercontrol.row.add([username, name + '  ' + lastname ,email, Status, 
                                 '<button type="button"   data-phone="' + phone + '" class="btn btn-sm btn-warning btn-block btnEditUser"  >Edit</button></td>'])
                                .draw(false);
                                rows.nodes().to$().attr('data-usertoken', lineToken);
                                rows.nodes().to$().attr('data-username', username);
                            });
                            $("#myModal").modal("hide");
                            $("#btnSaveUser").attr("data-action", "");
                            
                        }
                    }
                });
            };
            $(document).on('click',".btnEditUser", function (){
                var row = $(this).closest("tr");
                var name = (row.find("td:nth-child(2)").text());
                var namesplit = name.split(' ');
                $("#txtname").val(namesplit[0]);
                $("#txtLastname").val(namesplit[2]);
                $("#txtusername").val(row.attr("data-username"));
                $("#txtphone").val(row.find("td:nth-child(1)").text());
                $("#txtEmail").val(row.find("td:nth-child(3)").text());
                $("#Status").val(row.find("td:nth-child(4)").text());
                $("#Usertoken").val(row.attr("data-usertoken"));
                $("#btnSaveUser").attr("data-action", "Edit");
                $("#myModal").modal("show");
            });

            $(".btnAddUser").on('click', function () {
                $("#txtphone").val("");
                $("#txtEmail").val("");
                $("#txtname").val("");
                $("#txtLastname").val("");
                $("#Status").val("Active");
                $("#Usertoken").val("");
                $("#btnSaveUser").attr("data-action", "Insert");

                $("#myModal").modal("show");
            });


            $(".ResetToken").on('click', function () {
                var username = ($("#txtusername").val());
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/Reset_Token") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ username: username}),
                    success: function (response) {
                       
                    }

                });
            });





        });

    </script>
</asp:Content>
