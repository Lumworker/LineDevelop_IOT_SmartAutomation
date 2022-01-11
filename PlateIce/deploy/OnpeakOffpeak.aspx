<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="OnpeakOffpeak.aspx.cs" Inherits="IOTSmartAutomation.WebForm1" %>

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

        .selection {
            padding-top: 70px;
        }

        .table-center {
            border-radius: 5px;
            width: 50%;
            margin: 0px auto;
            float: none;
        }
    </style>

    <div class="selection">

        <div class="row">
            <div class="col-md-12 text-mode" style="margin: 10px 0;">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Standard Time</a></li>
                    <li><a href="#2" data-toggle="tab">Special Time</a></li>
                    <li><a href="#3" data-toggle="tab">Time Type</a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="tab-content ">
                    <div class="tab-pane active" id="1">
                        <div class="col-md-12 panel panel-default ">
                            <div class="panel-heading row">
                                <div class="col-md-12 text-left">
                                    <h4>Current Effect Date</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="currentEffectDateTable">
                                            <thead>
                                                <tr>
                                                    <th>Monday</th>
                                                    <th>Tuesday</th>
                                                    <th>Wednesday</th>
                                                    <th>Thursday</th>
                                                    <th>Friday</th>
                                                    <th>Saturday</th>
                                                    <th>Sunday</th>
                                                    <th>Effect Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="currentEffectDateBody">
                                                <tr>
                                                    <td>A</td>
                                                    <td>A</td>
                                                    <td>A</td>
                                                    <td>A</td>
                                                    <td>A</td>
                                                    <td>B</td>
                                                    <td>B</td>
                                                    <td>01/01/2019</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--END table-->
                                    </div>
                                </div>
                            </div>
                            <!--END Panel Body-->
                        </div>
                        <!--END Panel-->
                        <div class="col-md-12 panel panel-default " style="border: solid 1px;">
                            <div class="panel-heading row">
                                <div class="col-md-9 text-left">
                                    <h4>Upcoming Effect Date</h4>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="button" class="btn btn-success" id="upcomingAdd">Add</button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 row">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="upcoming">
                                            <thead>
                                                <tr>
                                                    <th>Monday</th>
                                                    <th>Tuesday</th>
                                                    <th>Wednesday</th>
                                                    <th>Thursday</th>
                                                    <th>Friday</th>
                                                    <th>Saturday</th>
                                                    <th>Sunday</th>
                                                    <th class="danger">Effect Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="upcomingBody">
                                                <%--<tr>
                                                            <td>A</td>
                                                            <td>A</td>
                                                            <td>A</td>
                                                            <td>A</td>
                                                            <td>A</td>
                                                            <td>B</td>
                                                            <td>B</td>
                                                            <td class="danger">2019/06/01 00:00:00</td>
                                                        </tr>--%>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--END Table-->
                                </div>
                            </div>
                            <!--END Panel Body-->
                        </div>
                        <!--END Panel-->
                    </div>
                    <!--End Tab1-->
                    <div class="tab-pane" id="2">
                        <div class="col-md-12 panel panel-default ">
                            <div class="panel-heading row">
                                <div class="col-md-9 text-left">
                                    <h4>Special Time</h4>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="button" class="btn btn-success" id="specialAdd">Add</button>
                                </div>
                            </div>
                            <div class="panel-body row">
                                <div class="col-md-12 row">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="specialTimeTable">
                                            <thead>
                                                <tr>
                                                    <th>Special Date </th>
                                                    <th>Type</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="specialTimeBody">
                                                <tr>
                                                    <td>04/01/2020</td>
                                                    <td>A</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--END Table-->
                            </div>
                        </div>
                        <!--END panel-->
                    </div>
                    <!--End Tab2-->
                    <div class="tab-pane" id="3">
                        <div class="col-md-12 panel panel-default ">
                            <div class="panel-heading row">
                                <div class="col-md-9 text-left">
                                    <h4>Time Type</h4>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="button" class="btn btn-success" id="timeTypeAdd">Add</button>
                                </div>
                            </div>
                            <div class="panel-body row">
                                <div class="col-md-12 row">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="timeTypeTable">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Time Start</th>
                                                    <th>Time End</th>
                                                </tr>
                                            </thead>
                                            <tbody id="timeTypeBody">
                                                <tr>
                                                    <td>A</td>
                                                    <td>00:00</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>A</td>
                                                    <td>22:00</td>
                                                    <td>23:59</td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>00:00</td>
                                                    <td>23:59</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--END Table-->
                            </div>
                        </div>
                        <!--END panel-->
                    </div>
                    <!--End Tab3-->
                </div>
            </div>
        </div>
    </div>
    <%-------------------------------------------Modal Start-------------------------------------%>
    <div class="modal fade" id="ModalStandardTime" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Add Standard Time</h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label7" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Effect Date : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                    <input type="text" id="effectDate" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label2" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Monday : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeMonday" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeMonday">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label3" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Tuesday : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeTuesday" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeTuesday">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label4" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Wednesday: "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeWednesday" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeWednesday">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label5" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Tursday : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeThursday" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeThursday">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label6" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Friday : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeFriday" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeFriday">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label1" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Saturday : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeSaturday" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeSaturday">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label8" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Sunday : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeSunday" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeSunday">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="btnSaveStandardTime">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <%--------------END ModalStandardTime-----------------%>

    <div class="modal fade" id="ModalSpecialTime" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Add Special Time</h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label9" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Effect Date : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                    <input type="text" id="specDate" class="form-control" onfocus="blur();">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label10" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Type : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="typeSpecial" class="form-control" disabled />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default buttonTimeType" type="button" data-type="typeSpecial">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="btnSaveSpecialTime">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <%--------------END ModalSpecialTime-----------------%>

    <div class="modal fade" id="ModalTimeType" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Add Time Type</h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <asp:Label ID="Label12" class="col-md-3 col-xs-12" runat="server" Font-Bold="True" Text="Type : "></asp:Label>
                            <div class="col-md-9 col-xs-12">
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control" id="typeName" />
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" type="button" id="addSelect" style="margin-right: 1rem;">Add</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="timeTypeModalTable">
                            <thead>
                                <tr>
                                    <th>Time Start</th>
                                    <th></th>
                                    <th>Time End</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="modalTimeTypeBody">
                                <tr id="cloneSelect">
                                    <td class="row">
                                        <select class="form-control col-md-6 hour">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                            <option>05</option>
                                            <option>06</option>
                                            <option>07</option>
                                            <option>08</option>
                                            <option>09</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                            <option>15</option>
                                            <option>16</option>
                                            <option>17</option>
                                            <option>18</option>
                                            <option>19</option>
                                            <option>20</option>
                                            <option>21</option>
                                            <option>22</option>
                                            <option>23</option>
                                        </select>
                                    </td>
                                    <td class="row">
                                        <select class="form-control col-md-6 min">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                            <option>05</option>
                                            <option>06</option>
                                            <option>07</option>
                                            <option>08</option>
                                            <option>09</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                            <option>15</option>
                                            <option>16</option>
                                            <option>17</option>
                                            <option>18</option>
                                            <option>19</option>
                                            <option>20</option>
                                            <option>21</option>
                                            <option>22</option>
                                            <option>23</option>
                                            <option>24</option>
                                            <option>25</option>
                                            <option>26</option>
                                            <option>27</option>
                                            <option>28</option>
                                            <option>29</option>
                                            <option>30</option>
                                            <option>31</option>
                                            <option>32</option>
                                            <option>33</option>
                                            <option>34</option>
                                            <option>35</option>
                                            <option>36</option>
                                            <option>37</option>
                                            <option>38</option>
                                            <option>39</option>
                                            <option>40</option>
                                            <option>41</option>
                                            <option>42</option>
                                            <option>43</option>
                                            <option>44</option>
                                            <option>45</option>
                                            <option>46</option>
                                            <option>47</option>
                                            <option>48</option>
                                            <option>49</option>
                                            <option>50</option>
                                            <option>51</option>
                                            <option>52</option>
                                            <option>53</option>
                                            <option>54</option>
                                            <option>55</option>
                                            <option>56</option>
                                            <option>57</option>
                                            <option>58</option>
                                            <option>59</option>
                                        </select>
                                    </td>
                                    <td class="row">
                                        <select class="form-control col-md-6 hour">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                            <option>05</option>
                                            <option>06</option>
                                            <option>07</option>
                                            <option>08</option>
                                            <option>09</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                            <option>15</option>
                                            <option>16</option>
                                            <option>17</option>
                                            <option>18</option>
                                            <option>19</option>
                                            <option>20</option>
                                            <option>21</option>
                                            <option>22</option>
                                            <option>23</option>
                                        </select>
                                    </td>
                                    <td class="row">
                                        <select class="form-control col-md-6 min">
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                            <option>05</option>
                                            <option>06</option>
                                            <option>07</option>
                                            <option>08</option>
                                            <option>09</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                            <option>15</option>
                                            <option>16</option>
                                            <option>17</option>
                                            <option>18</option>
                                            <option>19</option>
                                            <option>20</option>
                                            <option>21</option>
                                            <option>22</option>
                                            <option>23</option>
                                            <option>24</option>
                                            <option>25</option>
                                            <option>26</option>
                                            <option>27</option>
                                            <option>28</option>
                                            <option>29</option>
                                            <option>30</option>
                                            <option>31</option>
                                            <option>32</option>
                                            <option>33</option>
                                            <option>34</option>
                                            <option>35</option>
                                            <option>36</option>
                                            <option>37</option>
                                            <option>38</option>
                                            <option>39</option>
                                            <option>40</option>
                                            <option>41</option>
                                            <option>42</option>
                                            <option>43</option>
                                            <option>44</option>
                                            <option>45</option>
                                            <option>46</option>
                                            <option>47</option>
                                            <option>48</option>
                                            <option>49</option>
                                            <option>50</option>
                                            <option>51</option>
                                            <option>52</option>
                                            <option>53</option>
                                            <option>54</option>
                                            <option>55</option>
                                            <option>56</option>
                                            <option>57</option>
                                            <option>58</option>
                                            <option>59</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="btnSaveTimeType">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <%--------------END ModalSpecialTime-----------------%>

    <div class="modal fade" id="ModalSelectType" role="dialog">
        <div class="modal-dialog modal-sm" style="padding-top: 1rem;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 1em;">
                        <div class="col-md-9 col-lg-9 col-sm-12">
                            <h4 class="modal-title">Select Time Type</h4>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12" style="text-align: right;">
                            <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 28em;">

                    <table class="table table-bordered table-responsive">
                        <thead id="Thead2" runat="server">
                            <tr>
                                <th>Type</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                            </tr>
                        </thead>
                        <tbody id='selectTimeTypeBody' style="text-align: center;">
                            <tr>
                                <td><a href="javascript:void(0)" class="ClickSelectType">A </a></td>
                                <td><a href="javascript:void(0)" class="ClickSelectType">00:00</a></td>
                                <td><a href="javascript:void(0)" class="ClickSelectType">09:00</a></td>
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
    <script>


        $(document).ready(function () {

            
            callStandardTime();
            callTimeType('timeTypeBody');
            callSpecialTime();

            $("#upcomingAdd").on("click", function () {
                $("#effectDate").val('');
                $("#typeMonday").val('');
                $("#typeTuesday").val('');
                $("#typeWednesday").val('');
                $("#typeThursday").val('');
                $("#typeFriday").val('');
                $("#typeSaturday").val('');
                $("#typeSunday").val('');
                $("#ModalStandardTime").modal('show');
            });

            $("#specialAdd").on("click", function () {
                $("#specDate").val('');
                $("#typeSpecial").val('');
                $("#ModalSpecialTime").modal('show');
            });

            $("#timeTypeAdd").on("click", function () {
                $("#typeName").val('');
                $("#modalTimeTypeBody tr:gt(0)").remove();
                $('.hour').prop('selectedIndex', 0);
                $('.min').prop('selectedIndex', 0);
                $("#ModalTimeType").modal('show');
            });

            $("#addSelect").on("click", function () {
                $("#cloneSelect").clone().appendTo("#modalTimeTypeBody");
            });

            $("#typeName").on('keyup', function (e) {
                $(this).val($(this).val().toUpperCase());
            });

            $(".buttonTimeType").on("click", function () {
                callTimeType('selectTimeTypeBody');
                sessionStorage.setItem("timeType", $(this).attr("data-type"));
                $("#ModalSelectType").modal("show");
            });


            $(document).on('click', '.ClickSelectType', function () {
                var row = $(this).closest("tr");
                var idSelected = sessionStorage.getItem("timeType");
                $("#" + idSelected).val(row.find("td:nth-child(1)").text());
                $('#ModalSelectType').modal('hide');
                sessionStorage.removeItem("timeType");
            });

            $("#btnSaveStandardTime").on("click", function () {
                var effDate = $("#effectDate").val();
                var mon = $("#typeMonday").val();
                var tues = $("#typeTuesday").val();
                var wend = $("#typeWednesday").val();
                var thurs = $("#typeThursday").val();
                var fri = $("#typeFriday").val();
                var sat = $("#typeSaturday").val();
                var sun = $("#typeSunday").val();
                var data = { mon: mon, tues: tues, wend: wend, thurs: thurs, fri: fri, sat: sat, sun: sun, effDate: effDate };
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_Peak_StandardTime") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(data),
                    success: function (response) {
                        alert("Add Complete");
                        callStandardTime();
                        $("#ModalStandardTime").modal("hide");
                    }
                });
            });

            $("#btnSaveSpecialTime").on("click", function () {
                var specialDate = $("#specDate").val();
                var timeTypeSpecial = $("#typeSpecial").val();
                var data = { ID: 0, specialDate: specialDate, timeTypeSpecial: timeTypeSpecial, type: "Insert" };
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_Peak_SpecialTime") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(data),
                    success: function (response) {
                        alert("Add Complete");
                        callSpecialTime();
                        $("#ModalSpecialTime").modal("hide");
                    }
                });
            });

            $(document).on("click", ".ClickDeleteSpecialDate", function () {
                if (confirm('Delete This Special Date?')) {

                    var row = $(this).closest("tr");
                    var ID = parseInt($(this).attr("data-id"));
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_Peak_SpecialTime") %>",
                        contentType: 'application/json; charset=utf-8',
                        dataType: "json",
                        data: JSON.stringify({ ID: ID, specialDate: "", timeTypeSpecial: "", type: "Delete" }),
                        success: function (response) {
                            alert("Delete Complete");
                            callSpecialTime();
                        }
                    });

                }

            });


            $("#btnSaveTimeType").on("click", function () {
                if ($("#typeName").val() == "") {
                    alert("Please insert a Type name.");
                } else {
                    var typeName = $("#typeName").val();
                    $('#modalTimeTypeBody tr').each(function (index, value) {
                        var i = index + 1;
                        var row = $(this);
                        var timeStart = (row.find("td:nth-child(1)").find("select").val()) + ":" + (row.find("td:nth-child(2)").find("select").val());
                        var timeEnd = (row.find("td:nth-child(3)").find("select").val()) + ":" + (row.find("td:nth-child(4)").find("select").val());

                        var data = { typeName: typeName, timeStart: timeStart, timeEnd: timeEnd, index: i };
                        $.ajax({
                            type: "POST",
                            async: false,
                            url: "<%= ResolveUrl("MaintanceMahcine.aspx/SP_IOT_Peak_TimeType") %>",
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            data: JSON.stringify(data),
                            success: function (response) {
                                if (i == $('#modalTimeTypeBody tr').length) {
                                    alert("Add Complete");
                                }
                                callTimeType('timeTypeBody');
                                $("#ModalTimeType").modal("hide");
                            }
                        });
                    });
                }
            });

            function callStandardTime() {
                $("#currentEffectDateBody").empty();
                $("#upcomingBody").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListStandardTime") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            var framentUpcoming = "";
                            $.each(response.d, function (index, val) {
                                if (index == 0) {
                                    var monday = val[0];
                                    var tuesday = val[1];
                                    var wednesday = val[2];
                                    var thursday = val[3];
                                    var friday = val[4];
                                    var saturday = val[5];
                                    var sunday = val[6];
                                    var effectdate = val[7];
                                    var effectdate_ID = val[8];

                                    frament += '<tr data-ID="' + effectdate_ID + '">';
                                    frament += '<td>' + monday + '</td>';
                                    frament += '<td>' + tuesday + '</td>';
                                    frament += '<td>' + wednesday + '</td>';
                                    frament += '<td>' + thursday + '</td>';
                                    frament += '<td>' + friday + '</td>';
                                    frament += '<td>' + saturday + '</td>';
                                    frament += '<td>' + sunday + '</td>';
                                    frament += '<td>' + effectdate.substring(0, 10) + '</td>';
                                    frament += '</tr>';

                                    $("#currentEffectDateBody").append(frament);
                                } else {
                                    var monday = val[0];
                                    var tuesday = val[1];
                                    var wednesday = val[2];
                                    var thursday = val[3];
                                    var friday = val[4];
                                    var saturday = val[5];
                                    var sunday = val[6];
                                    var effectdate = val[7];
                                    var effectdate_ID = val[8];
                                    framentUpcoming += '<tr data-ID="' + effectdate_ID + '">';
                                    framentUpcoming += '<td>' + monday + '</td>';
                                    framentUpcoming += '<td>' + tuesday + '</td>';
                                    framentUpcoming += '<td>' + wednesday + '</td>';
                                    framentUpcoming += '<td>' + thursday + '</td>';
                                    framentUpcoming += '<td>' + friday + '</td>';
                                    framentUpcoming += '<td>' + saturday + '</td>';
                                    framentUpcoming += '<td>' + sunday + '</td>';
                                    framentUpcoming += '<td class="danger">' + effectdate.substring(0, 10) + '</td>';
                                    framentUpcoming += '</tr>';
                                }
                            });
                            $("#upcomingBody").append(framentUpcoming);


                        }
                    }
                });
            }

            function callTimeType(typecall) {
                var Call = typecall;
                $("#" + Call).empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListTimeType") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            $.each(response.d, function (index, val) {
                                var ID = val[0];
                                var Type = val[1];
                                var Time_Start = val[2];
                                var Time_End = val[3];
                                if (Call == 'timeTypeBody') {
                                    frament += '<tr data-ID="' + ID + '">';
                                    frament += '<td>' + Type + '</td>';
                                    frament += '<td>' + Time_Start.substring(0, 8) + '</td>';
                                    frament += '<td>' + Time_End.substring(0, 8) + '</td>';
                                    frament += '</tr>';
                                } else {
                                    frament += '<tr data-ID="' + ID + '">';
                                    frament += '<td><a href="javascript:void(0)" class="ClickSelectType">' + Type + '</a></td>';
                                    frament += '<td><a href="javascript:void(0)" class="ClickSelectType">' + Time_Start.substring(0, 8) + '</a></td>';
                                    frament += '<td><a href="javascript:void(0)" class="ClickSelectType">' + Time_End.substring(0, 8) + '</a></td>';
                                    frament += '</tr>';
                                }

                            });
                            $("#" + Call).append(frament);

                        }
                    }
                });
            }

            function callSpecialTime() {
                $("#specialTimeBody").empty();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<%= ResolveUrl("MaintanceMahcine.aspx/GetListSpecialTime") %>",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: JSON.stringify(),
                    success: function (response) {
                        if (response.d.length > 0) {
                            var frament = "";
                            $.each(response.d, function (index, val) {
                                var ID = val[0];
                                var Special_Date = val[1];
                                var TimeType = val[2];

                                frament += '<tr>';
                                frament += '<td>' + Special_Date + '</td>';
                                frament += '<td>' + TimeType + '</td>';
                                frament += '<td><button type="button" class="btn btn-danger ClickDeleteSpecialDate text-center" style="width: 50%;" data-ID="' + ID + '" >Delete</button></td>';
                                frament += '</tr>';
                            });
                            $("#specialTimeBody").append(frament);

                        }
                    }
                });
            }


        });
    </script>

</asp:Content>
