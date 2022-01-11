using MobileTask.AppCode;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace IOTSmartAutomation
{
    public partial class MaintanceMahcine : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        [WebMethod]
        public static List<ArrayList> GetCheckLineToken(string LineToken)
        {
            return new ClassBrowseNew().GetCheckLineToken(LineToken);
        }

        [WebMethod]
        public static string RegisterLineToken(string username, string password, string lineToken)
        {
            return new ClassBrowseNew().RegisterLineToken(username, password, lineToken);
        }

        [WebMethod]
        public static List<String[]> GetListCustomer()
        {
            return new ClassBrowseNew().GetListCustomer();
        }

        [WebMethod]
        public static List<String[]> GetListCustomerSite(string CustomerNo)
        {
            return new ClassBrowseNew().GetListCustomerSite(CustomerNo);
        }

        [WebMethod]
        public static List<String[]> GetListCustomerFactory(string CustomerNo, string site_code)
        {
            return new ClassBrowseNew().GetListCustomerFactory(CustomerNo, site_code);
        }

        [WebMethod]
        public static List<String[]> GetListCustomerMember(string CustomerNo, string site_code, string factory_no)
        {
            return new ClassBrowseNew().GetListCustomerMember(CustomerNo, site_code, factory_no);
        }

        [WebMethod]
        public static List<String[]> GetListMainMachine(string CustomerNo, string site_code, string factory_no)
        {
            return new ClassBrowseNew().GetListMainMachine(CustomerNo, site_code, factory_no);
        }

        [WebMethod]
        public static List<String[]> SP_IOT_BackEnd_Machine_Alarm_CheckList_Select(string main_machine_ID)
        {
            return new ClassBrowseNew().SP_IOT_BackEnd_Machine_Alarm_CheckList_Select(main_machine_ID);

        }

        [WebMethod]
        public static List<String[]> SP_IOT_BackEnd_Machine_RawData_CheckList_Select(string main_machine_ID)
        {
            return new ClassBrowseNew().SP_IOT_BackEnd_Machine_RawData_CheckList_Select(main_machine_ID);
        }

        [WebMethod]
        public static List<String[]> SP_IOT_BackEnd_User(string customer_no, string site_code, string factory_no)
        {
            return new ClassBrowseNew().SP_IOT_BackEnd_User(customer_no, site_code, factory_no);
        }

        [WebMethod]
        public static List<String[]> GetListAlarm_mst()
        {
            return new ClassBrowseNew().GetListAlarm_mst();
        }

        [WebMethod]
        public static List<String[]> GetListRawData_mst()
        {
            return new ClassBrowseNew().GetListRawData_mst();
        }

        [WebMethod]
        public static List<String[]> SP_IOT_BackEnd_AlarmLineConfig_Select(string Alarm_Id)
        {
            return new ClassBrowseNew().SP_IOT_BackEnd_AlarmLineConfig_Select(Alarm_Id);
        }

        [WebMethod]
        public static void SP_IOT_BackEnd_Customer_Site(string customer_no, string site_code, string site_name, string address, string phone1, string phone2, string email, string fax, string type)
        {
            new ClassBrowseNew().SP_IOT_BackEnd_Customer_Site(customer_no, site_code, site_name, address, phone1, phone2, email, fax, type);

        }

        [WebMethod]
        public static void SP_IOT_BackEnd_Customer_Factory(string customer_no, string site_code, int factory_no, string factory_name, string address, string phone1, string phone2, string email, string fax, string type, string Station)
        {
            new ClassBrowseNew().SP_IOT_BackEnd_Customer_Factory(customer_no, site_code, factory_no, factory_name, address, phone1, phone2, email, fax, type, Station);
        }

        [WebMethod]
        public static void SP_IOT_BackEnd_Customer_Member(string customer_no, string site_code, int factory_no, string username, string role, string type)
        {
            new ClassBrowseNew().SP_IOT_BackEnd_Customer_Member(customer_no, site_code, factory_no, username, role, type);
        }

        [WebMethod]
        public static void SP_IOT_BackEnd_Main_Machine(string customer_no, string site_code, int factory_no, string main_machine_ID, string main_machine_desc, string main_machine_type, string main_machine_model, string Certificated, string PLC, string Serial_Number, string Remark, int SetPoint_NextDrop, string type)
        {
            new ClassBrowseNew().SP_IOT_BackEnd_Main_Machine(customer_no, site_code, factory_no, main_machine_ID, main_machine_desc, main_machine_type, main_machine_model, Certificated, PLC, Serial_Number, Remark, SetPoint_NextDrop, type);
        }

        [WebMethod]
        public static void SP_IOT_BackEnd_Machine_Alarm_CheckList(string machine_ID, string main_machine_ID, string alarm_ID, string type)
        {
            new ClassBrowseNew().SP_IOT_BackEnd_Machine_Alarm_CheckList(machine_ID, main_machine_ID, alarm_ID, type);
        }

        [WebMethod]
        public static void SP_IOT_BackEnd_Machine_RawData_CheckList(string machine_ID, string main_machine_ID, string rawdata_ID, string type)
        {
            new ClassBrowseNew().SP_IOT_BackEnd_Machine_RawData_CheckList(machine_ID, main_machine_ID, rawdata_ID, type);
        }

        [WebMethod]
        public static string SP_IOT_BackEnd_Alarm_mst(string alarm_ID, string alarm_name,int alarm_Msg, string type)
        {
            return new ClassBrowseNew().SP_IOT_BackEnd_Alarm_mst(alarm_ID, alarm_name, alarm_Msg, type);
        }

        [WebMethod]
        public static string SP_IOT_BackEnd_RawData_mst(string rawdata_ID, string rawdata_name, string type)
        {
            return new ClassBrowseNew().SP_IOT_BackEnd_RawData_mst(rawdata_ID, rawdata_name, type);
        }

        [WebMethod]
        public static void SP_IOT_BackEnd_AlarmLineConfig(string id, string alarm_id, int Seq, int alarm_type, string msg_type, string msg, string prefix, string subfix, int msg_main_type, string PLC, string Status)
        {
            new ClassBrowseNew().SP_IOT_BackEnd_AlarmLineConfig(id, alarm_id, Seq, alarm_type, msg_type, msg, prefix, subfix, msg_main_type, PLC, Status);
        }

        [WebMethod]
        public static List<String[]> GetUsercontrol()
        {
            return new ClassBrowseNew().GetUsercontrol();
        }

        [WebMethod]
        public static String SP_IOT_BackEnd_Usercontrol(string username, string name, string lastname, string phone, string email, string Status, string Type)
        {
            return new ClassBrowseNew().SP_IOT_BackEnd_Usercontrol(username, name, lastname, phone, email, Status, Type);
        }

        [WebMethod]
        public static void Reset_Token(string username)
        {
            new ClassBrowseNew().Reset_Token(username);
        }

        [WebMethod]
        public static List<ArrayList> GET_TB_Package()
        {
            return new ClassBrowseNew().GET_TB_Package();
        }

        [WebMethod]
        public static string SP_Package(string PackageCode, string PackageName, string Status)
        {
            return new ClassBrowseNew().SP_Package(PackageCode, PackageName, Status);
        }

        [WebMethod]
        public static List<ArrayList> GET_VW_Customer_Package(string customer_no)
        {
            return new ClassBrowseNew().GET_VW_Customer_Package(customer_no);
        }

        [WebMethod]
        public static List<ArrayList> GET_Customer_Package(string notin,string search)
        {
            return new ClassBrowseNew().GET_Customer_Package(notin, search);
        }

        [WebMethod]
        public static string SP_Customer_Package(string customer_no, string PackageCode,string Active_date, string Expire_date, string Status)
        {
            return new ClassBrowseNew().SP_Customer_Package(customer_no, PackageCode, Active_date, Expire_date, Status);
        }

    }
}