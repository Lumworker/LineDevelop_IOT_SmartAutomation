<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="AlarmMaster.aspx.cs" Inherits="IOTSmartAutomation.AlarmMaster" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">

    <style>
        .form-control {
            min-width: 100%;
        }

        input[type=checkbox] {
            -ms-transform: scale(1.5);
            -moz-transform: scale(1.5);
            -webkit-transform: scale(1.5);
            -o-transform: scale(1.5);
            transform: scale(1.5);
            padding: 15px;
        }
        .checkbox-Msg{
            margin-left:20px !important;
        }
        .checkboxtext {
            font-size: 110%;
            display: inline;
        }

        .btn-bigger {
            width: 25rem;
            height: 15rem;
            float: right;
            margin-right: 2rem;
        }
    </style>

    <div class="page-header">
        <h2>Alarm Master</h2>
    </div>
    <div class="panel-group">
        <div class="panel panel-default" style="margin-top: 1em;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableAlarmMaster">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th width="3%">Alarm Massage</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="ListAlarmMaster">
                                    <tr id="LineAddAlarmMaster">
                                        <td><input type="text" id="txtAlarmMasterCode" class="form-control" placeholder="Alarm Master Code" disabled /></td>
                                        <td><input type="text" id="txtAlarmMasterName" class="form-control" placeholder="Alarm Master Name" /></td>
                                        <td><input class="form-check-input checkbox-Msg" type="checkbox" id="checkbox_alarm_Msg" style="margin-right: 5px;margin-top: 13px;"> </td>
                                        <td><button type="button" id="btnAddAlarmMaster" class="btn btn-success btn-block">Add</button></td>
                                        
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


    <div class="modal fade" id="ModalLineConfigAlarm" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Detail LineConfig Alarm
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
                                <li class="active"><a href="#alarm" data-toggle="tab">Error</a></li>
                                <li><a href="#rawdata" data-toggle="tab">Normal</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content ">
                                <div class="tab-pane active" id="alarm">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <asp:Label ID="Label9" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Type Message"></asp:Label>
                                            <div class="col-md-9 col-xs-12">
                                                <label class="radio-inline">
                                                    <input type="radio" name="radioTypeLineConfig" value="Text" checked>Text</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="radioTypeLineConfig" value="Flex">Flex</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 row">
                                        <table id="EM_Tables" class="table table-bordered table-responsive">
                                            <thead id="EM_theadtable" runat="server">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Msg</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id='List_TypeTrue'>
                                                <tr>
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">Text</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage1" style="min-width: 100%" /></td>
                                                    <td>
                                                        <select class="form-control" style="min-width: 100%">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                        </select></td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessageprefix" /></td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessagesubfix" /></td>
                                                </tr>
                                                <tr class="RadiotoHide">
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">Text</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage2" style="min-width: 100%" />
                                                    </td>
                                                    <td>
                                                        <select class="form-control" style="min-width: 100%">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                        </select></td>
                                                </tr>
                                                <tr class="RadiotoHide">
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">url</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage3" style="min-width: 100%" />
                                                    </td>
                                                    <td>
                                                        <select class="form-control" style="min-width: 100%">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                        </select></td>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="">PLC</label>
                                                    </td>
                                                </tr>
                                                <tr class="RadiotoHide">
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">url</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage4" style="min-width: 100%" />
                                                    </td>
                                                    <td>
                                                        <select class="form-control" style="min-width: 100%">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                        </select></td>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="">PLC</label>
                                                    </td>
                                                </tr>
                                                <tr class="RadiotoHide">
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">url</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage5" style="min-width: 100%" />
                                                    </td>
                                                    <td>
                                                        <select class="form-control" style="min-width: 100%">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                        </select></td>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="">PLC</label>
                                                    </td>
                                                </tr>
                                                <tr class="RadiotoHide">
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">url</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage6" style="min-width: 100%" />
                                                    </td>
                                                    <td>
                                                        <select class="form-control" style="min-width: 100%">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                        </select></td>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="">PLC</label>
                                                    </td>
                                                </tr>
                                                <tr class="RadiotoHide">
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">Text</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage7" style="min-width: 100%" /></td>
                                                    <td>
                                                        <select class="form-control" style="min-width: 100%">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                        </select></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="rawdata">
                                    <div class="col-md-12 row">
                                        <table id="EM_Table" class="table table-bordered table-responsive">
                                            <thead id="Thead1" runat="server">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Msg</th>
                                                </tr>
                                            </thead>
                                            <tbody id='List_TypeTFlase'>
                                                <tr>
                                                    <td>
                                                        <span class="form-control" style="min-width: 100%">Text</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage0" style="min-width: 100%" /></td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage1prefix" style="min-width: 100%" /></td>
                                                    <td>
                                                        <input type="text" class="form-control" id="txtMessage1subfix" style="min-width: 100%" /></td>
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
                    <button type="button" class="btn btn-warning" id="btnClickModalAddCheckList">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $.ajax({
                type: "POST",
                async: false,
                url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListAlarm_mst") %>",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({ Type: "" }),
                success: function (response) {
                    if (response.d.length > 0) {
                        $.each(response.d, function (index, val) {
                            var frament = "";
                            var Code = val[0];
                            var Name = val[1];
                            var Msg = val[2];
                            frament += '<tr>';
                            frament += '<td><input class="form-control" type="text" value="' + Code + '" disabled/></td>';
                            frament += '<td><input class="form-control" type="text" value="' + Name + '"/></td>';
                            if (Msg == "False") {
                                frament += '<td><input class="form-check-input checkbox-Msg" type="checkbox" ></td>';
                            } else {
                                frament += '<td><input class="form-check-input checkbox-Msg" type="checkbox"  checked></td>';
                            }
                            frament += '<td><button type="button" class="btn btn-info btn-block btnDetailAlarmMaster" data-type="'+Msg+'">Detail</button></td>';
                            frament += '<td><button type="button" class="btn btn-warning btn-block btnUpdateAlarmMaster">Save</button></td>';
                            frament += '<td><button type="button" class="btn btn-danger btn-block btnDeleteAlarmMaster">Delete</button></td></tr>';
                            frament += '</tr>';
                            $("#ListAlarmMaster").append(frament);
                        });
                    }
                }
            });


            $(document).on('change', 'input[name=radioTypeLineConfig]', function () {
                //alert($(this).val());
                if ($(this).val() == "Text") {
                    $(".RadiotoHide").hide();
                    $("#List_TypeTrue > tr").each(function () {
                        if (!$(this).find("td:nth-child(2)").find("input[type=text]").hasClass("GetFromDatabase")) {
                            $(this).find("td:nth-child(2)").find("input[type=text]").val("").attr("data-id", 0);
                        }
                    });
                    $("#txtMessageprefix").val("");
                    $("#txtMessagesubfix").val("");
                    $("#txtMessage0").val("").attr("data-id", 0);
                } else {
                    $(".RadiotoHide").show();
                }
            });

            $(document).on('click', '.btnDetailAlarmMaster', function () {
                var row = $(this).closest("tr");
                var txtAlarmMasterCode = row.find("td:nth-child(1)").find("input").val();
                var txtAlarmMasterName = row.find("td:nth-child(2)").find("input").val();
                $("#txtMessage0").val("").attr("data-id", 0);
                $("#txtMessage1").val("").attr("data-id", 0);
                $("#txtMessage2").val("").attr("data-id", 0);
                $("#txtMessage3").val("").attr("data-id", 0);
                $("#txtMessage4").val("").attr("data-id", 0);
                $("#txtMessage5").val("").attr("data-id", 0);
                $("#txtMessage6").val("").attr("data-id", 0);
                $("#txtMessage7").val("").attr("data-id", 0);
                $("#txtMessageprefix").val("");
                $("#txtMessagesubfix").val("");

                //$("#List_TypeTrue").find("tr:nth-child(2)").find("td:nth-child(2)").find("span").text("รหัสคู่มือ : " + txtAlarmMasterCode);

                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_AlarmLineConfig_Select") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ Alarm_Id: txtAlarmMasterCode }),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var i = 1;
                            $.each(response.d, function (index, val) {
                                var ID = val[0];
                                var alarm_id = val[1];
                                var Seq = val[2];
                                var alarm_type = val[3];
                                var msg_type = val[4];
                                var msg_massage = val[5];
                                var PLC = val[6];
                                var TypeLine = val[7];
                                var prefix = val[8];
                                var subfix = val[9];

                                if (TypeLine == "Text") {
                                    $(".RadiotoHide").hide();
                                    $('input:radio[name=radioTypeLineConfig]')[0].checked = true;
                                }
                                else {
                                    $(".RadiotoHide").show();
                                    $('input:radio[name=radioTypeLineConfig]')[1].checked = true;
                                }
                                if (alarm_type == "True") {
                                    $("#txtMessage" + i).attr("data-id", ID).val(msg_massage).addClass("GetFromDatabase");
                                    $("#txtMessage" + i).closest("tr").find("td:nth-child(3)").find("select").val(Seq);
                                    if (Seq == "1") {
                                        $("#txtMessageprefix").val(prefix);
                                        $("#txtMessagesubfix").val(subfix);
                                    }
                                    if (PLC == "True") {
                                        $("#txtMessage" + i).closest("tr").find("td:nth-child(4)").find("input[type='checkbox']").prop("checked", true).attr("data-checked", PLC);
                                    } else {
                                        $("#txtMessage" + i).closest("tr").find("td:nth-child(4)").find("input[type='checkbox']").prop("checked", false).attr("data-checked", PLC);
                                    }
                                    i++;
                                } else if (Seq == "1" && alarm_type == "False") {
                                    $("#txtMessage1prefix").val(prefix);
                                    $("#txtMessage1subfix").val(subfix);
                                    $("#txtMessage0").attr("data-id", ID).val(msg_massage).addClass("GetFromDatabase");
                                }


                            });
                        } else {
                            $(".RadiotoHide").hide();
                            $("#txtMessage0").val("").attr("data-id", 0);
                            $("#txtMessage1").val("").attr("data-id", 0);
                            $("#txtMessage2").val("").attr("data-id", 0);
                            $("#txtMessage3").val("").attr("data-id", 0);
                            $("#txtMessage4").val("").attr("data-id", 0);
                            $("#txtMessage5").val("").attr("data-id", 0);
                            $("#txtMessage6").val("").attr("data-id", 0);
                            $("#txtMessage7").val("").attr("data-id", 0);
                        }
                        $("#List_TypeTrue").attr("data-alarmid", txtAlarmMasterCode);

                        $("#ModalLineConfigAlarm").modal("show");
                    }
                });
            });

            $(document).on('change', '#ModalLineConfigAlarm input[type="text"] , #ModalLineConfigAlarm input[type="checkbox"], #ModalLineConfigAlarm select', function () {
                $(this).addClass("ISChangeData");
            });


            $("#btnClickModalAddCheckList").on('click', function () {
                var Status = "";
                var returndata = "";
                var alarm_id = $("#List_TypeTrue").attr("data-alarmid");
                var type = $('input:radio[name=radioTypeLineConfig]:checked').val();

                if ($("#txtMessage0").hasClass("ISChangeData")) {
                    var MsgNormal = $("#txtMessage0").val();
                    var MsgNormalID = $("#txtMessage0").attr("data-id");
                    var txtMessage1prefix = $("#txtMessage1prefix").val();
                    var txtMessage1subfix = $("#txtMessage1subfix").val();
                    if (MsgNormalID == "0") { Status = "Insert"; } else { Status = "Edit"; }
                    //console.log(MsgNormalID + " : " + MsgNormal + " : " + Status + " : " + type);
                    ReturnLine({ id: MsgNormalID, alarm_id: alarm_id, Seq: 1, alarm_type: 0, msg_type: "text", msg: MsgNormal, prefix: txtMessage1prefix, subfix: txtMessage1subfix, msg_main_type: 1, PLC: "NULL", Status: Status });
                }

                if (type == "Text") {
                    if ($("#txtMessage1").hasClass("ISChangeData")) {
                        var msg = $("#txtMessage1").val();
                        var id = $("#txtMessage1").attr("data-id");
                        var txtMessageprefix = $("#txtMessageprefix").val();
                        var txtMessagesubfix = $("#txtMessagesubfix").val();
                        var msg_type = ($("#txtMessage1").closest("tr").find("td:nth-child(1)").find("span").text()).toLowerCase();
                        if (id == "0") { Status = "Insert"; } else { Status = "Edit"; }
                        //console.log(id + " : " + msg + " : " + Status + " : " + type);
                        returndata = ReturnLine({ id: id, alarm_id: alarm_id, Seq: 1, alarm_type: 1, msg_type: msg_type, msg: msg, prefix: txtMessageprefix, subfix: txtMessagesubfix, msg_main_type: 0, PLC: "NULL", Status: Status });
                    }
                }
                else {
                    if ($("#txtMessage2").val() != "" && $("#txtMessage3").val() != "" && $("#txtMessage4").val() != "" && $("#txtMessage5").val() != "" && $("#txtMessage6").val() != "" && $("#txtMessage7").val() != "") {
                        $("#List_TypeTrue > tr").each(function (index, value) {
                            if ($(this).find("td:nth-child(2)").find("input[type=text]").hasClass("ISChangeData") || $(this).find("td:nth-child(3)").find("select").hasClass("ISChangeData") || $(this).find("td:nth-child(4)").find("input[type='checkbox']").hasClass("ISChangeData") || $(this).find("td:nth-child(4)").find("input[type=text]").hasClass("ISChangeData") || $(this).find("td:nth-child(5)").find("input[type=text]").hasClass("ISChangeData")) {

                                if (id == "0") { Status = "Insert"; } else { Status = "Edit"; }

                                var msg = $(this).find("td:nth-child(2)").find("input[type=text]").val();
                                var id = $(this).find("td:nth-child(2)").find("input[type=text]").attr("data-id");
                                var seq = $(this).find("td:nth-child(3)").find("select").val();
                                var PLC = $(this).find("td:nth-child(4)").find("input[type='checkbox']").is(':checked') ? 1 : $(this).find("td:nth-child(4)").find("input[type='checkbox']").attr("data-checked") != "False" ? "NULL" : 0;
                                var prefix = index == 0 ? $(this).find("td:nth-child(4)").find("input[type=text]").val() : "";
                                var subfix = index == 0 ? $(this).find("td:nth-child(5)").find("input[type=text]").val() : "";
                                var msg_main_type = index == 0 ? 1 : 0;
                                var msg_type = ($(this).find("td:nth-child(1)").find("span").text()).toLowerCase();
                                console.log({ id: id, alarm_id: alarm_id, Seq: seq, alarm_type: 1, msg_type: msg_type, msg: msg, prefix: prefix, subfix: subfix, msg_main_type: msg_main_type, PLC: PLC, Status: Status });
                                returndata = ReturnLine({ id: id, alarm_id: alarm_id, Seq: seq, alarm_type: 1, msg_type: msg_type, msg: msg, prefix: prefix, subfix: subfix, msg_main_type: msg_main_type, PLC: PLC, Status: Status });
                            }
                        });
                    } else {
                        alert("input text in box");
                    }
                }

                if (returndata == "Complete") { alert("Process Complete"); }
                $("#ModalLineConfigAlarm").modal("hide");
            });

            function ReturnLine(Setdata) {
                var data = "";
                $.ajax({
                    type: "POST",
                    async: false,
                    global: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_AlarmLineConfig") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(Setdata),
                    success: function (response) {
                        data = "Complete";
                    }
                });
                return data;
            }

            $("#btnAddAlarmMaster").on('click', function () {
                var txtAlarmMasterName = $("#txtAlarmMasterName").val();
                var alarm_Msg = $("#checkbox_alarm_Msg").is(':checked') ? 1 : 0; 
                alert(txtAlarmMasterName);
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Alarm_mst") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ alarm_ID: "", alarm_name: txtAlarmMasterName, alarm_Msg: alarm_Msg, type: "Insert" }),
                    success: function (response) {
                        var frament = "";

                        frament += '<tr>';
                        frament += '<td><input class="form-control" type="text" value="' + response.d + '" disabled/></td>';
                        frament += '<td><input class="form-control" type="text" value="' + txtAlarmMasterName + '"/></td>';
                         if (alarm_Msg == 0) {
                                frament += '<td><input class="form-check-input" type="checkbox" style="margin-right: 5px;margin-left:5px; 5px;margin-top: 13px;"></td>';
                            } else {
                                frament += '<td><input class="form-check-input" type="checkbox" style="margin-right: 5px;margin-left:5px; 5px;margin-top: 13px;" checked></td>';
                            }
                        frament += '<td><button type="button" class="btn btn-info btn-block btnDetailAlarmMaster">Detail</button></td>';
                        frament += '<td><button type="button" class="btn btn-warning btn-block btnUpdateAlarmMaster">Save</button></td>';
                        frament += '<td><button type="button" class="btn btn-danger btn-block btnDeleteAlarmMaster">Delete</button></td></tr>';
                        frament += '</tr>';
                        $("#ListAlarmMaster").append(frament);
                        $("#txtAlarmMasterName").val("");
                        $("#checkbox_alarm_Msg").prop('checked', true);
                        alert("Add Complete");
                    }
                });
            });


            $(document).on('click', '.btnUpdateAlarmMaster', function () {
                var row = $(this).closest("tr");
                var txtAlarmMasterCode = row.find("td:nth-child(1)").find("input").val();
                var txtAlarmMasterName = row.find("td:nth-child(2)").find("input").val();
                var alarm_Msg = row.find("td:nth-child(2)").find("input").is(':checked') ? 1 : 0; 
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Alarm_mst") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify({ alarm_ID: txtAlarmMasterCode, alarm_name: txtAlarmMasterName,alarm_Msg:alarm_Msg, type: "Edit" }),
                    success: function (response) {
                        alert("Update Complete");
                    }
                });
            });

            $(document).on('click', '.btnDeleteAlarmMaster', function () {
                if (confirm("Confirm Delete Alarm??")) {
                    var row = $(this).closest("tr");
                    var txtAlarmMasterCode = row.find("td:nth-child(1)").find("input").val();
                    var txtAlarmMasterName = row.find("td:nth-child(2)").find("input").val();
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_BackEnd_Alarm_mst") %>",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify({ alarm_ID: txtAlarmMasterCode, alarm_name: txtAlarmMasterName,alarm_Msg:0, type: "Delete" }),
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
