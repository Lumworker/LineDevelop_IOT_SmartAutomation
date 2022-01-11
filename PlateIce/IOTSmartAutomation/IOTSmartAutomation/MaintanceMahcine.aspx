<%@ Page Title="Machine Configuration" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="MaintanceMahcine.aspx.cs" Inherits="IOTSmartAutomation.MaintanceMahcine" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <style>
        .form-control {
            min-width: 100%;
        }

        .row-eq-height {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }

        @media only screen and (max-width: 990px) {
            .row-eq-height {
                display: -webkit-box;
                display: grid;
            }
        }

        .SelectLine, .SelectLine:focus {
            color: #f0ad4e;
            font-weight: bold;
        }
    </style>

    <div class="page-header">
        <h2>Machine Configuration</h2>
        <div class="row">
            <div class="form-group col-md-5 col-sm-6 col-xs-12">
                <asp:Label ID="Label7" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Customer : "></asp:Label>
                <div class="col-md-9 col-xs-12">
                    <div class="input-group">
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
    <div class="row">
        <div class="row-eq-height">

            <div class="col-md-6 col-xs-12" id="DisplayCustomerSite" style="display: none">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9 col-xs-9">
                                <h4>
                                    <strong>Customer Site</strong>
                                </h4>
                            </div>
                            <div class="col-md-3 col-xs-3 text-right">
                                <button type="button" class="btn btn-success" id="btnClickModalAddCustomerSite">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 style="color: red; font-weight: bold">**Select Site to Factory**</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tableCustomerSite">
                                        <thead>
                                            <tr>
                                                <th>Site Code</th>
                                                <th>Site Name</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="ListCustomerSite">
                                            <tr>
                                                <td><a href="javascirpt:void(0)" class="ClickSelectLineSite">VPIP</a></td>
                                                <td><a href="javascirpt:void(0)" class="ClickSelectLineSite">โรงน้ำแข็งวรภัทร</a></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-block">Edit</button></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-block">Delete</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--END row-->
                    </div>
                </div>
            </div>
            <!--End col 6-->


            <div class="col-md-6 col-xs-12" id="DisplayCustomerFactory" style="display: none">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <h4>
                                    <strong>Customer Factory</strong>
                                </h4>
                            </div>
                            <div class="col-md-3 text-right">
                                <button type="button" class="btn btn-success" id="btnClickModalAddCustomerFactory">Add</button>
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 style="color: red; font-weight: bold">**Select Factory to Customer Member & Machine**</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tableCustomerFactory">
                                        <thead>
                                            <tr>
                                                <th>Factory No</th>
                                                <th>Factory Name</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="ListCustomerFactory">
                                            <tr>
                                                <td><a href="javascript:void(0)" class="ClickSelectLineFactory">1</a></td>
                                                <td><a href="javascript:void(0)" class="ClickSelectLineFactory">โรงน้ำแข็งวรภัทร-1</a></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-block">Edit</button></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-block">Delete</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--END row-->
                    </div>
                </div>
            </div>
            <!--End col 6-->
        </div>
    </div>

    <div class="panel panel-default" style="margin-top: 1em; display: none" id="DisplayMemberAndMachine">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 text-mode" style="margin: 10px 0;">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#1" data-toggle="tab">Customer Member</a></li>
                        <li><a href="#2" data-toggle="tab">Main Machine</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="tab-content ">
                        <div class="tab-pane active" id="1">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-success" id="btnClickModalAddCustomerMember">Add</button>
                            </div>
                            <div class="col-md-12 row">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tableCustomerMember">
                                        <thead>
                                            <tr>
                                                <th>username</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ListCustomerMember">
                                            <tr>
                                                <td>0922564730</td>
                                                <td>Name Lastname</td>
                                                <td>Manager</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-block">Edit</button></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-block">Delete</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--END Table-->
                        </div>
                        <!--End Tab1-->
                        <div class="tab-pane" id="2">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-success" id="btnClickModalAddMainMachine">Add</button>
                            </div>
                            <div class="col-md-12 row">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tableMainMachine">
                                        <thead>
                                            <tr>
                                                <th>Main Machine ID</th>
                                                <th>Main Machine Name</th>
                                                <th>Main Machine Type</th>
                                                <th>Certificated</th>
                                                <th>PLC</th>
                                                <th>Set Point</th>
                                                <th>Machine Size</th>
                                                <th></th>
                                                <th></th>
                                                <%--<th></th>--%>
                                            </tr>
                                        </thead>
                                        <tbody id="ListMainMachine">
                                            <%--<tr>
                                                <td>TH10104VPIP01TI01</td>
                                                <td>เครื่องทำน้ำแข็ง 41 มม-1</td>
                                                <td>TI</td>
                                                <td>NoUL</td>
                                                <td>PLC</td>
                                                <td>50</td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-block">Detail</button></td>
                                            </tr>--%>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--END Table-->
                        </div>
                        <!--End Tab2-->
                    </div>
                </div>
            </div>
        </div>
        <!--panel-body-->
    </div>


    <div class="modal fade" id="ModalListCustomer" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Detail Machine
                            </h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                    <%--<div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="Lot_myInput" placeholder="Search Lot" autocomplete="off" onkeypress="detect_enter_keyboard(event)" style="max-width: 100%" />
                        </div>
                    </div>--%>
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


    <div class="modal fade" id="ModalListCheckBoxAlarmANDRawData" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Detail Machine
                            </h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <%--<div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="Lot_myInput" placeholder="Search Lot" autocomplete="off" onkeypress="detect_enter_keyboard(event)" style="max-width: 100%" />
                        </div>
                    </div>--%>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">
                    <div class="row">
                        <div class="col-md-12 text-mode" style="margin: 10px 0;">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#alarm" data-toggle="tab">Alarm</a></li>
                                <li><a href="#rawdata" data-toggle="tab">Raw Data</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content ">
                                <div class="tab-pane active" id="alarm">
                                    <div class="col-md-12 row">
                                        <table id="EM_Table" class="table table-bordered table-responsive">
                                            <thead id="EM_theadtable" runat="server">
                                                <tr>
                                                    <th></th>
                                                    <th>Alarm ID</th>
                                                    <th>Alarm Name</th>
                                                </tr>
                                            </thead>
                                            <tbody id='ListCheckbox_MainMachineAlarm'>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <input type="checkbox" /></td>
                                                    <td>TIR001</td>
                                                    <td>Alarm1</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="rawdata">
                                    <div class="col-md-12 row">
                                        <table id="EM_Table2" class="table table-bordered table-responsive">
                                            <thead id="Thead1" runat="server">
                                                <tr>
                                                    <th></th>
                                                    <th>RawData ID</th>
                                                    <th>RawData Name</th>
                                                </tr>
                                            </thead>
                                            <tbody id='ListCheckbox_MainMachineRawData'>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <input type="checkbox" /></td>
                                                    <td>TIN001</td>
                                                    <td>RawData1</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="float:left;"><input type="checkbox" name="select-all" id="select-all" /> Select all</div>
                    <%--<a id="select-all" href="javascript:void(0);" style="float:left;">Select all</a>--%>
                    <button type="button" class="btn btn-warning" id="btnClickModalAddCheckList">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ModalCustomerSite" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Customer Site : <span id="NameCustomerSite"></span>
                            </h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label2" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Site Code : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtSiteCode" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label3" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Site Name : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtSiteName" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label4" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Address Site: "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtSiteAddress" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label5" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Phone1 Site : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtSitePhone1" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label6" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Phone2 Site : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtSitePhone2" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label1" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Email Site : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtSiteEmail" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label8" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Fax Site : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtSiteFax" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="btnSaveCustomerSite">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalCustomerFactory" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Customer Factory : <span id="NameCustomerFactory"></span>: <span id="NameSiteFactory"></span>
                            </h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label9" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Factory Code : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="number" id="txtFactoryCode" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label10" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Factory Name : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtFactoryName" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label11" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Address Factory: "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtFactoryAddress" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label12" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Phone1 Factory : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtFactoryPhone1" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label13" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Phone2 Factory : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtFactoryPhone2" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label14" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Email Factory : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtFactoryEmail" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label15" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Fax Factory : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtFactoryFax" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label20" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Station ID : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtStation" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="btnSaveCustomerFactory">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ModalCustomerMember" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Customer Member : <span id="NameCustomerMember"></span>: <span id="NameSiteMember"></span>
                            </h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label16" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="User : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="txtMemberCode" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button id="buttonModalCustomerMemberCode" class="btn btn-default" type="button" disabled>
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label17" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Member Name :"></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtMemberName" class="form-control" style="min-width: 100%" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label18" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Role Member: "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <%--<input type="text" id="txtMemberRole" class="form-control" style="min-width: 100%" />--%>
                                <select id="txtMemberRole" class="form-control" style="min-width: 100%">
                                    <option>Owner</option>
                                    <option>Manager</option>
                                    <option>Technician</option>
                                    <option>Operator</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="btnSaveCustomerMember">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalListUser" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">List User
                            </h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">

                    <table id="EM_TableUser" class="table table-bordered table-responsive">
                        <thead id="Thead3" runat="server">
                            <tr>
                                <th>UserName</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody id='ListUser'>
                            <tr>
                                <td><a href="javascript:void(0)" class="ClickSelectLineUser" data-dismiss="modal"></a></td>
                                <td><a href="javascript:void(0)" class="ClickSelectLineUser" data-dismiss="modal"></a></td>
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

    <div class="modal fade" id="ModalMainMachine" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Main Machine : <span id="NameCustomerMainMachine"></span>: <span id="NameSiteMainMachine"></span>
                            </h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label21" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="MainMachine Name :"></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" id="txtMainMachineDesc" class="form-control" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label22" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Machine Type :"></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <select id="txtMainMachineType" class="form-control" style="min-width: 100%">
                                    <option value="TI">TubeIce</option>
                                    <option value="BI">BlockIce</option>
                                    <option value="IP">IcePacking</option>
                                    <option value="CR">ColdRoom</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label23" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Certificated : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <select id="txtMainMachineCertificated" class="form-control" style="min-width: 100%">
                                    <option value="NoUL">No UL</option>
                                    <option value="UL">UL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label24" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="PLC : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <select id="txtMainMachinePLC" class="form-control" style="min-width: 100%">
                                    <option value="0">NO PLC</option>
                                    <option value="1">PLC</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label25" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Set Point : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <input type="Number" id="txtMainMachineSetPoint" class="form-control" max="50" min="0" style="min-width: 100%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label19" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Machine Size : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <select id="txtMainMachineSize" class="form-control" style="min-width: 100%">
                                    <option value="41">41</option>
                                    <option value="19">19</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="btnSaveMainMachine">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {



            $('#select-all').click(function (event) {
                if (this.checked) {
                    $("input:checkbox").attr('checked', true);
                } else {
                    $("input:checkbox").attr('checked', false);
                }
                    
            });


            $("#btnClickModalAddCustomerSite").on('click', function () {
                var row = $(this).closest("tr");
                $("#NameCustomerSite").text($("#ListCustomerSite").find("tr").attr("data-cusno"));
                $("#txtSiteCode").prop("disabled", false).val("");
                $("#txtSiteName").val("");
                $("#txtSiteAddress").val("");
                $("#txtSitePhone1").val("");
                $("#txtSitePhone2").val("");
                $("#txtSiteEmail").val("");
                $("#txtSiteFax").val("");
                $("#btnSaveCustomerSite").attr("data-action", "Insert");
                $("#ModalCustomerSite").modal("show");
            });
            $(document).on('click', '.ClickEditLineSite', function () {
                var row = $(this).closest("tr");
                $("#NameCustomerSite").text(row.attr("data-cusno"));
                $("#txtSiteCode").prop("disabled", true).val(row.find("td:nth-child(1)").text());
                $("#txtSiteName").val(row.find("td:nth-child(2)").text());
                $("#txtSiteAddress").val(row.find("td:nth-child(3)").text());
                $("#txtSitePhone1").val(row.find("td:nth-child(4)").text());
                $("#txtSitePhone2").val(row.find("td:nth-child(5)").text());
                $("#txtSiteEmail").val(row.find("td:nth-child(6)").text());
                $("#txtSiteFax").val(row.find("td:nth-child(7)").text());
                $("#btnSaveCustomerSite").attr("data-action", "Edit");
                $("#ModalCustomerSite").modal("show");
            });
            //ที่ต้องใช้ (document).on เพราะ jsทำงานครั้งแรกครั้งเดียว มันจะหา Class 



            $("#btnSaveCustomerSite").on('click', function () {
                var type = $("#btnSaveCustomerSite").attr("data-action");
                var CustomerNo = $("#NameCustomerSite").text();
                var SiteCode = $("#txtSiteCode").val();
                var SiteName = $("#txtSiteName").val();
                var SiteAddress = $("#txtSiteAddress").val();
                var SitePhone1 = $("#txtSitePhone1").val();
                var SitePhone2 = $("#txtSitePhone2").val();
                var SiteEmail = $("#txtSiteEmail").val();
                var SiteFax = $("#txtSiteFax").val();
                //alert($("#NameCustomerSite").text() + " / " + type);
                var data = { customer_no: CustomerNo, site_code: SiteCode, site_name: SiteName, address: SiteAddress, phone1: SitePhone1, phone2: SitePhone2, email: SiteEmail, fax: SiteFax, type: type };
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Customer_Site") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(data),
                    success: function (response) {
                        if (type == "Insert") {
                            alert("Add Complete");
                        } else if (type == "Edit") {
                            alert("Edit Complete");
                        }
                        CallCustomerSite(CustomerNo);
                        $("#ModalCustomerSite").modal("hide");
                    }
                });

            });
            $(document).on('click', '.ClickDeleteLineSite', function () {
                if (confirm("Are you want for delete site?")) {
                    var row = $(this).closest("tr");
                    var CustomerNo = row.attr("data-cusno");
                    var SiteCode = row.find("td:nth-child(1)").text();

                    var data = { customer_no: CustomerNo, site_code: SiteCode, site_name: "", address: "", phone1: "", phone2: "", email: "", fax: "", type: "Delete" };
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Customer_Site") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify(data),
                        success: function (response) {
                            CallCustomerSite(CustomerNo);
                            alert("Edit Complete");
                        }
                    });
                }
            });



            $("#btnClickModalAddCustomerFactory").on('click', function () {
                var row = $(this).closest("tr");
                $("#NameCustomerFactory").text($("#ListCustomerFactory").attr("data-cusno"));
                $("#NameSiteFactory").text($("#ListCustomerFactory").attr("data-sitecode"));
                $("#txtFactoryCode").prop("disabled", false).val("");
                $("#txtFactoryName").val("");
                $("#txtFactoryAddress").val("");
                $("#txtFactoryPhone1").val("");
                $("#txtFactoryPhone2").val("");
                $("#txtFactoryEmail").val("");
                $("#txtFactoryFax").val("");
                $("#btnSaveCustomerFactory").attr("data-action", "Insert");
                $("#ModalCustomerFactory").modal("show");
            });
            $(document).on('click', '.ClickEditLineFactory', function () {
                var row = $(this).closest("tr");
                $("#NameCustomerFactory").text($("#ListCustomerFactory").attr("data-cusno"));
                $("#NameSiteFactory").text($("#ListCustomerFactory").attr("data-sitecode"));
                $("#txtFactoryCode").prop("disabled", true).val(row.find("td:nth-child(1)").text());
                $("#txtFactoryName").val(row.find("td:nth-child(2)").text());
                $("#txtFactoryAddress").val(row.find("td:nth-child(3)").text());
                $("#txtFactoryPhone1").val(row.find("td:nth-child(4)").text());
                $("#txtFactoryPhone2").val(row.find("td:nth-child(5)").text());
                $("#txtFactoryEmail").val(row.find("td:nth-child(6)").text());
                $("#txtFactoryFax").val(row.find("td:nth-child(7)").text());
                $("#txtStation").val(row.find("td:nth-child(8)").text());
                $("#btnSaveCustomerFactory").attr("data-action", "Edit");
                $("#ModalCustomerFactory").modal("show");
            });

            $("#btnSaveCustomerFactory").on('click', function () {
                var type = $("#btnSaveCustomerFactory").attr("data-action");
                var CustomerNo = $("#NameCustomerFactory").text();
                var SiteNo = $("#NameSiteFactory").text();
                var FactoryCode = parseInt($("#txtFactoryCode").val());
                var FactoryName = $("#txtFactoryName").val();
                var FactoryAddress = $("#txtFactoryAddress").val();
                var FactoryPhone1 = $("#txtFactoryPhone1").val();
                var FactoryPhone2 = $("#txtFactoryPhone2").val();
                var FactoryEmail = $("#txtFactoryEmail").val();
                var FactoryFax = $("#txtFactoryFax").val();
                var Station = $("#txtStation").val();
                //alert(CustomerNo + " / " + SiteNo + " / " + type);
                var data = { customer_no: CustomerNo, site_code: SiteNo, factory_no: FactoryCode, factory_name: FactoryName, address: FactoryAddress, phone1: FactoryPhone1, phone2: FactoryPhone2, email: FactoryEmail, fax: FactoryFax, type: type,Station:Station };
                console.log(data);
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Customer_Factory") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(data),
                    success: function (response) {
                        if (type == "Insert") {
                            alert("Add Complete");
                        } else if (type == "Edit") {
                            alert("Edit Complete");
                        }
                        CallCustomerFactory(CustomerNo, SiteNo);
                        $("#ModalCustomerFactory").modal("hide");
                    }
                });

            });

            $(document).on('click', '.ClickDeleteLineFactory', function () {
                if (confirm("Are you want for delete Factory?")) {
                    var row = $(this).closest("tr");
                    var CustomerNo = $("#ListCustomerFactory").attr("data-cusno");
                    var SiteNo = $("#ListCustomerFactory").attr("data-sitecode");
                    var FactoryNo = parseInt(row.find("td:nth-child(1)").text());

                    var data = { customer_no: CustomerNo, site_code: SiteNo, factory_no: FactoryNo, factory_name: "", address: "", phone1: "", phone2: "", email: "", fax: "", type: "Delete" };
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Customer_Factory") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify(data),
                        success: function (response) {
                            CallCustomerFactory(CustomerNo, SiteNo);
                            alert("Delete Complete");
                        }
                    });
                }
            });


            $("#btnClickModalAddCustomerMember").on('click', function () {
                $("#NameCustomerMember").text($("#ListCustomerMember").attr("data-cusno"));
                $("#NameSiteMember").text($("#ListCustomerMember").attr("data-sitecode"));
                $("#buttonModalCustomerMemberCode").prop("disabled", false);
                $("#txtMemberCode").val("");
                $("#txtMemberName").val("");
                $("#txtMemberRole").val("");
                $("#btnSaveCustomerMember").attr("data-action", "Insert");
                $("#ModalCustomerMember").modal("show");
            });
            $(document).on('click', '.ClickEditLineMember', function () {
                var row = $(this).closest("tr");
                $("#NameCustomerMember").text($("#ListCustomerMember").attr("data-cusno"));
                $("#NameSiteMember").text($("#ListCustomerMember").attr("data-sitecode"));
                $("#buttonModalCustomerMemberCode").prop("disabled", true);
                $("#txtMemberCode").val(row.find("td:nth-child(1)").text());
                $("#txtMemberName").val(row.find("td:nth-child(2)").text());
                $("#txtMemberRole").val(row.find("td:nth-child(3)").text());
                $("#btnSaveCustomerMember").attr("data-action", "Edit");
                $("#ModalCustomerMember").modal("show");
            });
            $("#buttonModalCustomerMemberCode").on('click', function () {
                var customer_no = $("#ListCustomerMember").attr("data-cusno");
                var site_code = $("#ListCustomerMember").attr("data-sitecode");
                var factory_no = $("#ListCustomerMember").attr("data-factoryno");
                CallUser(customer_no, site_code, factory_no);
            });
            $(document).on('click', '.ClickSelectLineUser', function () {
                var row = $(this).closest("tr");
                $("#txtMemberCode").val(row.find("td:nth-child(1)").text());
                $("#txtMemberName").val(row.find("td:nth-child(2)").text());
                $("#ModalListUser").modal("hide");
            });

            $("#btnSaveCustomerMember").on('click', function () {
                var type = $("#btnSaveCustomerMember").attr("data-action");
                var customer_no = $("#ListCustomerMember").attr("data-cusno");
                var site_code = $("#ListCustomerMember").attr("data-sitecode");
                var factory_no = $("#ListCustomerMember").attr("data-factoryno");
                var username = $("#txtMemberCode").val();
                var role = $("#txtMemberRole").val();
                //alert(CustomerNo + " / " + SiteNo + " / " + type);
                var data = { customer_no: customer_no, site_code: site_code, factory_no: factory_no, username: username, role: role, type: type };
                //console.log(data);
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Customer_Member") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(data),
                    success: function (response) {
                        if (type == "Insert") {
                            alert("Add Complete");
                        } else if (type == "Edit") {
                            alert("Edit Complete");
                        }
                        CallCustomerMember(customer_no, site_code, factory_no);
                        $("#ModalCustomerMember").modal("hide");
                    }
                });
            });

            $(document).on('click', '.ClickDeleteLineMember', function () {
                if (confirm("Are you want for delete Member?")) {
                    var row = $(this).closest("tr");
                    var customer_no = $("#ListCustomerMember").attr("data-cusno");
                    var site_code = $("#ListCustomerMember").attr("data-sitecode");
                    var factory_no = $("#ListCustomerMember").attr("data-factoryno");
                    var username = row.find("td:nth-child(1)").text();

                    var data = { customer_no: customer_no, site_code: site_code, factory_no: factory_no, username: username, role: "", type: "Delete" };
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Customer_Member") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify(data),
                        success: function (response) {
                            CallCustomerMember(customer_no, site_code, factory_no);
                            alert("Delete Complete");
                        }
                    });
                }
            });


            $("#btnClickModalAddMainMachine").on('click', function () {
                $("#NameCustomerMainMachine").text($("#ListMainMachine").attr("data-cusno"));
                $("#NameSiteMainMachine").text($("#ListMainMachine").attr("data-sitecode"));
                $("#txtMainMachineDesc").val("");
                $("#txtMainMachineType").val("");
                $("#txtMainMachineCertificated").val("");
                $("#txtMainMachinePLC").val("");
                $("#txtMainMachineSetPoint").val("");
                $("#txtMainMachineSize").val("");
                $("#btnSaveMainMachine").attr("data-mainid", "");
                $("#btnSaveMainMachine").attr("data-action", "Insert");
                $("#ModalMainMachine").modal("show");
            });
            $(document).on('click', '.ClickEditLineMainMachine', function () {
                var row = $(this).closest("tr");
                $("#NameCustomerMainMachine").text($("#ListMainMachine").attr("data-cusno"));
                $("#NameSiteMainMachine").text($("#ListMainMachine").attr("data-sitecode"));
                $("#txtMainMachineDesc").val(row.find("td:nth-child(2)").text());
                $("#txtMainMachineType").val(row.find("td:nth-child(3)").text());
                $("#txtMainMachineCertificated").val(row.find("td:nth-child(4)").text());
                $("#txtMainMachinePLC").val(row.find("td:nth-child(5)").text());
                $("#txtMainMachineSetPoint").val(row.find("td:nth-child(6)").text());
                $("#txtMainMachineSize").val(row.find("td:nth-child(7)").text());
                $("#btnSaveMainMachine").attr("data-action", "Edit");
                $("#btnSaveMainMachine").attr("data-mainid", row.find("td:nth-child(1)").text());
                $("#ModalMainMachine").modal("show");
            });
            $("#btnSaveMainMachine").on('click', function () {
                var type = $("#btnSaveMainMachine").attr("data-action");
                var customer_no = $("#ListMainMachine").attr("data-cusno");
                var site_code = $("#ListMainMachine").attr("data-sitecode");
                var factory_no = parseInt($("#ListMainMachine").attr("data-factoryno"));
                var main_machine_ID = type == "Insert" ? "" : $("#btnSaveMainMachine").attr("data-mainid");
                var main_machine_desc = $("#txtMainMachineDesc").val();
                var main_machine_type = $("#txtMainMachineType").val();
                var main_machine_model = "";
                var Certificated = $("#txtMainMachineCertificated").val();
                var PLC = $("#txtMainMachinePLC").val();
                var Serial_Number = "";
                var Remark = "";
                var SetPoint_NextDrop = parseInt($("#txtMainMachineSetPoint").val());
                var MachineSize = $("#txtMainMachineSize").val();
                var data = { customer_no: customer_no, site_code: site_code, factory_no: factory_no, main_machine_ID: main_machine_ID, main_machine_desc: main_machine_desc, main_machine_type: main_machine_type, main_machine_model: main_machine_model, Certificated: Certificated, PLC: PLC, Serial_Number: Serial_Number, Remark: Remark, SetPoint_NextDrop: SetPoint_NextDrop, main_machine_size: MachineSize, type: type };
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Main_Machine") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(data),
                    success: function (response) {
                        if (type == "Insert") {
                            alert("Add Complete");
                        } else if (type == "Edit") {
                            alert("Edit Complete");
                        }
                        CallMainMachine(customer_no, site_code, factory_no);
                        $("#ModalMainMachine").modal("hide");
                    }
                });

            });


            $("#buttonModalCustomer").on('click', function () {
                CallCustomer();
            });
            $(document).on('click', '.ClickSelectLineCustomer', function () {
                var row = $(this).closest("tr");
                $("#txtCustomer").val(row.find("td:nth-child(2)").text());
                $('#ModalListCustomer').modal('hide');
                CallCustomerSite(row.find("td:nth-child(1)").text());
            });


            $(document).on('click', '.ClickSelectLineSite', function () {
                var row = $(this).closest("tr");
                if (row.find("td").find("a").hasClass("SelectLine")) {
                    row.find("td").find("a").removeClass("SelectLine");
                    $("#ListCustomerFactory").empty();

                    $("#ListCustomerFactory").find("tr").find("td").find("a").removeClass("SelectLine");

                    $("#DisplayCustomerFactory").hide();
                    $("#DisplayMemberAndMachine").hide();


                } else {
                    $("#ListCustomerSite").find("tr").find("td").find("a").removeClass("SelectLine");
                    row.find("td").find("a").addClass("SelectLine");
                    CallCustomerFactory(row.attr("data-cusno"), row.find("td:nth-child(1)").text());
                }
            });


            $(document).on('click', '.ClickSelectLineFactory', function () {
                var row = $(this).closest("tr");
                $("#ListMainMachine").empty();
                $("#ListCustomerMember").empty();
                if (row.find("td").find("a").hasClass("SelectLine")) {
                    row.find("td").find("a").removeClass("SelectLine");
                    $("#DisplayMemberAndMachine").hide();
                } else {
                    row.find("td").find("a").addClass("SelectLine");
                    CallCustomerMember($("#ListCustomerFactory").attr("data-cusno"), $("#ListCustomerFactory").attr("data-sitecode"), row.find("td:nth-child(1)").text());
                    CallMainMachine($("#ListCustomerFactory").attr("data-cusno"), $("#ListCustomerFactory").attr("data-sitecode"), row.find("td:nth-child(1)").text());
                }
            });

            $(document).on('click', '.clickDetailMainMachine', function () {
                var row = $(this).closest("tr");
                CallCheckListAlarm(row.find("td:nth-child(1)").text());
                CallCheckListRawData(row.find("td:nth-child(1)").text());
                $('#ModalListCheckBoxAlarmANDRawData').modal('show');
            });

            $("#btnClickModalAddCheckList").on('click', function () {
                var main_machine_ID = $("#ListCheckbox_MainMachineAlarm > tr").attr("data-mainmachine");
                $("#ListCheckbox_MainMachineAlarm > tr").each(function () {
                    var check_to_checked = $(this).find("input[type=checkbox]").prop("checked");
                    var check_to_Database = $(this).find("input[type=checkbox]").hasClass("GetDatabase");
                    var Status = "";
                    var alarm_ID = $(this).find("td:nth-child(2)").text();
                    var machine_ID = main_machine_ID + '' + alarm_ID;
                    if (check_to_checked && !check_to_Database) { Status = "Insert"; }
                    else if (!check_to_checked && check_to_Database) { Status = "Delete"; }
                    else { Status = "None"; }
                    if (Status != "None") {
                        var data = { machine_ID: machine_ID, main_machine_ID: main_machine_ID, alarm_ID: alarm_ID, type: Status };
                        //console.log(data);
                        $.ajax({
                            type: "POST",
                            async: false,
                            url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Machine_Alarm_CheckList") %>",
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            data: JSON.stringify(data),
                            success: function (response) {
                                $("#ModalListCheckBoxAlarmANDRawData").modal('hide');
                            }
                        });
                    }
                });

                $("#ListCheckbox_MainMachineRawData > tr").each(function () {
                    var check_to_checked = $(this).find("input[type=checkbox]").prop("checked");
                    var check_to_Database = $(this).find("input[type=checkbox]").hasClass("GetDatabase");
                    var Status = "";
                    var rawdata_ID = $(this).find("td:nth-child(2)").text();
                    var machine_ID = main_machine_ID + '' + rawdata_ID;
                    if (check_to_checked && !check_to_Database) { Status = "Insert"; }
                    else if (!check_to_checked && check_to_Database) { Status = "Delete"; }
                    else { Status = "None"; }
                    if (Status != "None") {
                        var data = { machine_ID: machine_ID, main_machine_ID: main_machine_ID, rawdata_ID: rawdata_ID, type: Status };
                        console.log(data);
                        $.ajax({
                            type: "POST",
                            async: false,
                            url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Machine_RawData_CheckList") %>",
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            data: JSON.stringify(data),
                            success: function (response) { }
                        });
                    }
                }).promise().done(function () {
                    alert('Update Complete');
                    //$('#ModalListCheckBoxAlarmANDRawData').modal('hide');
                });

            });



            function CallCheckListRawData(main_machine_ID) {
                $("#ListCheckbox_MainMachineRawData").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Machine_RawData_CheckList_Select") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ main_machine_ID: main_machine_ID }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            $.each(response.d, function (index, val) {
                                var rawdata_ID = val[0];
                                var rawdata_name = val[1];
                                var machine_ID = val[2];
                                //var main_machine_ID = val[3];
                                var CheckList = val[4] == 1 ? "checked class='GetDatabase'" : "";

                                frament += '<tr data-mainmachine="' + main_machine_ID + '">';
                                frament += '<td style="text-align: center;"><input type="checkbox" ' + CheckList + '/></td>';
                                frament += '<td>' + rawdata_ID + '</td>';
                                frament += '<td>' + rawdata_name + '</td>';
                                frament += '</tr>';
                            });
                            $("#ListCheckbox_MainMachineRawData").append(frament);

                        }
                    }
                });
            }

            function CallCheckListAlarm(main_machine_ID) {
                $("#ListCheckbox_MainMachineAlarm").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Machine_Alarm_CheckList_Select") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ main_machine_ID: main_machine_ID }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            $.each(response.d, function (index, val) {
                                var alarm_ID = val[0];
                                var alarm_name = val[1];
                                var machine_ID = val[2];
                                //var main_machine_ID = val[3];
                                var CheckList = val[4] == 1 ? "checked class='GetDatabase'" : "";

                                frament += '<tr data-mainmachine="' + main_machine_ID + '">';
                                frament += '<td style="text-align: center;"><input type="checkbox" ' + CheckList + '/></td>';
                                frament += '<td>' + alarm_ID + '</td>';
                                frament += '<td>' + alarm_name + '</td>';
                                frament += '</tr>';
                            });
                            $("#ListCheckbox_MainMachineAlarm").append(frament);


                        }
                    }
                });
            }

            function CallUser(customer_no, site_code, factory_no) {
                $("#ListUser").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_User") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ customer_no: customer_no, site_code: site_code, factory_no: factory_no }),
                    success: function (response) {
                        var frament = "";
                        $.each(response.d, function (index, val) {
                            var Code = val[0];
                            var Name = val[1];
                            frament += '<tr>';
                            frament += '<td><a href="javascript:void(0)" class="ClickSelectLineUser">' + Code + '</a></td>';
                            frament += '<td><a href="javascript:void(0)" class="ClickSelectLineUser">' + Name + '</a></td>';
                            frament += '</tr>';
                        });
                        $("#ListUser").append(frament);
                        $("#ModalListUser").modal("show");
                    }
                });
            }


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

            function CallCustomerSite(CustomerNo) {
                $("#ListCustomerSite").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListCustomerSite") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ CustomerNo: CustomerNo }),
                    success: function (response) {
                        var frament = "";
                        $.each(response.d, function (index, val) {
                            var Code = val[0];
                            var Name = val[1];
                            var customer_no = val[2];
                            var address = val[3];
                            var phone1 = val[4];
                            var phone2 = val[5];
                            var email = val[6];
                            var fax = val[7];

                            frament += '<tr data-cusno="' + customer_no + '">';
                            frament += '<td><a href="#" class="ClickSelectLineSite">' + Code + '</a></td>';
                            frament += '<td><a href="#" class="ClickSelectLineSite">' + Name + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + address + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + phone1 + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + phone2 + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + email + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + fax + '</a></td>';
                            frament += '<td><button type="button" class="btn btn-warning btn-block ClickEditLineSite">Edit</button></td>';
                            frament += '<td><button type="button" class="btn btn-danger btn-block ClickDeleteLineSite">Delete</button></td>';
                            frament += '</tr>';
                        });
                        $("#ListCustomerSite").append(frament);
                        $("#DisplayCustomerSite").show();
                        $("#DisplayCustomerFactory").hide();
                        $("#DisplayMemberAndMachine").hide();
                    }
                });
            }

            function CallCustomerFactory(CustomerNo, site_code) {
                $("#ListCustomerFactory").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListCustomerFactory") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ CustomerNo: CustomerNo, site_code: site_code }),
                    success: function (response) {
                        var frament = "";
                        $.each(response.d, function (index, val) {
                            var Code = val[0];
                            var Name = val[1];
                            var address = val[2];
                            var phone1 = val[3];
                            var phone2 = val[4];
                            var email = val[5];
                            var fax = val[6];
                            var Station = val[7];

                            frament += '<tr>';
                            frament += '<td><a href="#" class="ClickSelectLineFactory">' + Code + '</a></td>';
                            frament += '<td><a href="#" class="ClickSelectLineFactory">' + Name + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + address + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + phone1 + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + phone2 + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + email + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + fax + '</a></td>';
                            frament += '<td style="display:none"><a href="#">' + Station + '</a></td>';
                            frament += '<td><button type="button" class="btn btn-warning btn-block ClickEditLineFactory">Edit</button></td>';
                            frament += '<td><button type="button" class="btn btn-danger btn-block ClickDeleteLineFactory">Delete</button></td>';
                            frament += '</tr>';
                        });
                        $("#ListCustomerFactory").attr('data-sitecode', site_code);
                        $("#ListCustomerFactory").attr('data-cusno', CustomerNo);
                        $("#ListCustomerFactory").append(frament);
                        $("#DisplayCustomerFactory").show();
                        $("#DisplayMemberAndMachine").hide();
                    }
                });
            }

            function CallCustomerMember(CustomerNo, site_code, factory_no) {
                $("#ListCustomerMember").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListCustomerMember") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ CustomerNo: CustomerNo, site_code: site_code, factory_no: factory_no }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            $.each(response.d, function (index, val) {
                                var username = val[0];
                                var FullName = val[1];
                                var role = val[2];
                                frament += '<tr>';
                                frament += '<td>' + username + '</td>';
                                frament += '<td>' + FullName + '</td>';
                                frament += '<td>' + role + '</td>';
                                frament += '<td><button type="button" class="btn btn-warning btn-block ClickEditLineMember">Edit</button></td>';
                                frament += '<td><button type="button" class="btn btn-danger btn-block ClickDeleteLineMember">Delete</button></td>';
                                frament += '</tr>';
                            });
                            $("#ListCustomerMember").append(frament);
                        }
                        $("#ListCustomerMember").attr("data-cusno", CustomerNo);
                        $("#ListCustomerMember").attr("data-sitecode", site_code);
                        $("#ListCustomerMember").attr("data-factoryno", factory_no);
                    }
                });
            }

            function CallMainMachine(CustomerNo, site_code, factory_no) {
                $("#ListMainMachine").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListMainMachine") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ CustomerNo: CustomerNo, site_code: site_code, factory_no: factory_no }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            $.each(response.d, function (index, val) {
                                var main_machine_ID = val[0];
                                var main_machine_desc = val[1];
                                var main_machine_type = val[2];
                                var Certificated = val[3];
                                var PLC = val[4];
                                var SetPoint_NextDrop = val[5];
                                var main_machine_size = val[6];
                                frament += '<tr>';
                                frament += '<td>' + main_machine_ID + '</td>';
                                frament += '<td>' + main_machine_desc + '</td>';
                                frament += '<td>' + main_machine_type + '</td>';
                                frament += '<td>' + Certificated + '</td>';
                                frament += '<td>' + PLC + '</td>';
                                frament += '<td>' + SetPoint_NextDrop + '</td>';
                                frament += '<td>' + main_machine_size + '</td>';
                                frament += '<td><button type="button" class="btn btn-info btn-block clickDetailMainMachine">Detail</button></td>';
                                frament += '<td><button type="button" class="btn btn-warning btn-block ClickEditLineMainMachine">Edit</button></td>';
                                //frament += '<td><button type="button" class="btn btn-danger btn-block ClickDeleteLineMainMachine">Delete</button></td>';
                                frament += '</tr>';
                            });
                            $("#ListMainMachine").append(frament);
                        }
                        $("#ListMainMachine").attr("data-cusno", CustomerNo);
                        $("#ListMainMachine").attr("data-sitecode", site_code);
                        $("#ListMainMachine").attr("data-factoryno", factory_no);
                        $("#DisplayMemberAndMachine").show();
                    }
                });
            }

        });


    </script>


</asp:Content>
