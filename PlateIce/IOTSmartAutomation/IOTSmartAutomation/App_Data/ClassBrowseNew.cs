using System;
using System.Web;
using System.Web.Services;
using System.Web.Services.Protocols;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Net;
using System.Collections.Specialized;
using System.Globalization;
using System.Text;
using System.Collections.Generic;
using System.Collections;

namespace MobileTask.AppCode
{
    public class ClassBrowseNew
    {
        //public static String connectDB = "Data Source=203.151.62.137;Initial Catalog=IOTPatkol_PlateIce;Persist Security Info=True;User ID=sa;Password=@Patkol.com; Connect Timeout=0; pooling=true; Max Pool Size=50000";
        public static String connectDB = "Data Source=172.25.238.2;Initial Catalog=IOTPatkol;Persist Security Info=True;User ID=sa;Password=@Patkol.com; Connect Timeout=0; pooling=true; Max Pool Size=50000";
        
        //Center_IOTPatkol
        //public static String connectDB_Center = "Data Source=203.151.62.137;Initial Catalog=Center_IOTPatkol;Persist Security Info=True;User ID=sa;Password=@Patkol.com; Connect Timeout=0; pooling=true; Max Pool Size=50000";
        public static String connectDB_Center = "Data Source=172.25.238.2;Initial Catalog=Center_IOTPatkol;Persist Security Info=True;User ID=sa;Password=@Patkol.com; Connect Timeout=0; pooling=true; Max Pool Size=50000";

        //public String GetUser()
        //{
        //    var UserDomain = HttpContext.Current.Request.LogonUserIdentity.Name;
        //    UserDomain = UserDomain.Replace("PATKOL\\", "");
        //    return UserDomain;
        //}

        public List<ArrayList> GetCheckLineToken(string LineToken)
        {
            List<ArrayList> GetCheckLineToken = new List<ArrayList>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [username] FROM [dbo].[TB_User] WHERE [lineToken] = '" + LineToken + "' AND [Status]='Active' ";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            ArrayList get = new ArrayList();
                            for (int i = 0; i < reader.FieldCount; i++) { get.Add(reader[i].ToString()); }
                            GetCheckLineToken.Add(get);
                        }
                    }
                }
            }
            return GetCheckLineToken;
        }

        public string RegisterLineToken(string username, string password, string lineToken)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_Register_Line", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("username", username);
            cmd.Parameters.AddWithValue("password", password);
            cmd.Parameters.AddWithValue("lineToken", lineToken);
            connect.Open();
            //cmd.ExecuteNonQuery();
            SqlDataReader rs = cmd.ExecuteReader();
            string returnData = "";
            if (rs.Read()) { returnData = rs["Status"].ToString(); }
            connect.Close();
            return returnData;
        }


        public List<String[]> GetListCustomer()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [customer_no],[customer_name] FROM [dbo].[TB_Customer]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[2];
                            Data[0] = reader["customer_no"].ToString().Trim();
                            Data[1] = reader["customer_name"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> GetListCustomerSite(string CustomerNo)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [customer_no],[site_code],[site_name],[address],[phone1],[phone2],[email],[fax] FROM [dbo].[TB_Customer_Site] WHERE [customer_no] = '" + CustomerNo + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[8];
                            Data[0] = reader["site_code"].ToString().Trim();
                            Data[1] = reader["site_name"].ToString().Trim();
                            Data[2] = reader["customer_no"].ToString().Trim();
                            Data[3] = reader["address"].ToString().Trim();
                            Data[4] = reader["phone1"].ToString().Trim();
                            Data[5] = reader["phone2"].ToString().Trim();
                            Data[6] = reader["email"].ToString().Trim();
                            Data[7] = reader["fax"].ToString().Trim();

                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> GetListCustomerFactory(string CustomerNo, string site_code)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [factory_no] ,[factory_name],[address],[phone1],[phone2],[email],[fax],[Station] FROM [dbo].[TB_Customer_Factory] WHERE [customer_no] = '" + CustomerNo + "' AND [site_code] = '" + site_code + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[8];
                            Data[0] = reader["factory_no"].ToString().Trim();
                            Data[1] = reader["factory_name"].ToString().Trim();
                            Data[2] = reader["address"].ToString().Trim();
                            Data[3] = reader["phone1"].ToString().Trim();
                            Data[4] = reader["phone2"].ToString().Trim();
                            Data[5] = reader["email"].ToString().Trim();
                            Data[6] = reader["fax"].ToString().Trim();
                            Data[7] = reader["Station"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> GetListCustomerMember(string CustomerNo, string site_code, string factory_no)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [username],[FullName],[role] FROM [dbo].[VW_IOT_Customer_Member] WHERE [customer_no] = '" + CustomerNo + "' AND [site_code] = '" + site_code + "' AND [factory_no] = '" + factory_no + "' ORDER BY [role]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[3];
                            Data[0] = reader["username"].ToString().Trim();
                            Data[1] = reader["FullName"].ToString().Trim();
                            Data[2] = reader["role"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> GetListMainMachine(string CustomerNo, string site_code, string factory_no)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [main_machine_ID] ,[main_machine_desc] ,[main_machine_type] ,[Certificated] ,[PLC] ,[SetPoint_NextDrop],[main_machine_size] FROM [dbo].[TB_MainMachine] WHERE [customer_no] = '" + CustomerNo + "' AND [site_code] = '" + site_code + "' AND [factory_no] = '" + factory_no + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[7];
                            Data[0] = reader["main_machine_ID"].ToString().Trim();
                            Data[1] = reader["main_machine_desc"].ToString().Trim();
                            Data[2] = reader["main_machine_type"].ToString().Trim();
                            Data[3] = reader["Certificated"].ToString().Trim();
                            Data[4] = reader["PLC"].ToString().Trim();
                            Data[5] = reader["SetPoint_NextDrop"].ToString().Trim();
                            Data[6] = reader["main_machine_size"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }


        public List<String[]> SP_IOT_BackEnd_Machine_Alarm_CheckList_Select(string main_machine_ID)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "EXEC SP_IOT_BackEnd_Machine_Alarm_CheckList_Select '" + main_machine_ID + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[5];
                            Data[0] = reader["alarm_ID"].ToString().Trim();
                            Data[1] = reader["alarm_name"].ToString().Trim();
                            Data[2] = reader["machine_ID"].ToString().Trim();
                            Data[3] = reader["main_machine_ID"].ToString().Trim();
                            Data[4] = reader["CheckList"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> SP_IOT_BackEnd_Machine_RawData_CheckList_Select(string main_machine_ID)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "EXEC SP_IOT_BackEnd_Machine_RawData_CheckList_Select '" + main_machine_ID + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[5];
                            Data[0] = reader["rawdata_ID"].ToString().Trim();
                            Data[1] = reader["rawdata_name"].ToString().Trim();
                            Data[2] = reader["machine_ID"].ToString().Trim();
                            Data[3] = reader["main_machine_ID"].ToString().Trim();
                            Data[4] = reader["CheckList"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> SP_IOT_BackEnd_User(string customer_no, string site_code, string factory_no)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "EXEC SP_IOT_BackEnd_User '" + customer_no + "','" + site_code + "','" + factory_no + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[2];
                            Data[0] = reader["username"].ToString().Trim();
                            Data[1] = reader["name"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> GetListAlarm_mst()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [alarm_ID],[alarm_name] FROM [dbo].[TB_Alarm_mst]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[2];
                            Data[0] = reader["alarm_ID"].ToString().Trim();
                            Data[1] = reader["alarm_name"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> GetListRawData_mst()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [rawdata_ID] ,[rawdata_name] FROM [dbo].[TB_PlateIce_RawData_mst]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[2];
                            Data[0] = reader["rawdata_ID"].ToString().Trim();
                            Data[1] = reader["rawdata_name"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }


        public List<String[]> SP_IOT_BackEnd_AlarmLineConfig_Select(string Alarm_Id)
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "EXEC SP_IOT_BackEnd_AlarmLineConfig_Select '" + Alarm_Id + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[11];
                            Data[0] = reader["ID"].ToString().Trim();
                            Data[1] = reader["alarm_id"].ToString().Trim();
                            Data[2] = reader["Seq"].ToString().Trim();
                            Data[3] = reader["alarm_type"].ToString().Trim();
                            Data[4] = reader["msg_type"].ToString().Trim();
                            Data[5] = reader["msg_massage"].ToString().Trim();
                            Data[6] = reader["PLC"].ToString().Trim();
                            Data[7] = reader["TypeLine"].ToString().Trim();
                            Data[8] = reader["prefix"].ToString().Trim();
                            Data[9] = reader["subfix"].ToString().Trim();
                            Data[10] = reader["alarm_group"].ToString().Trim();

                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public void SP_IOT_BackEnd_Customer_Site(string customer_no, string site_code, string site_name, string address, string phone1, string phone2, string email, string fax, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Customer_Site", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("customer_no", customer_no);
            cmd.Parameters.AddWithValue("site_code", site_code);
            cmd.Parameters.AddWithValue("site_name", site_name);
            cmd.Parameters.AddWithValue("address", address);
            cmd.Parameters.AddWithValue("phone1", phone1);
            cmd.Parameters.AddWithValue("phone2", phone2);
            cmd.Parameters.AddWithValue("email", email);
            cmd.Parameters.AddWithValue("fax", fax);
            cmd.Parameters.AddWithValue("type", type);
            connect.Open();
            cmd.ExecuteNonQuery();
            //SqlDataReader rs = cmd.ExecuteReader();
            //string returnData = "";
            //if (rs.Read()) { returnData = rs["MaxNumber"].ToString(); }
            connect.Close();
            //return returnData;
        }

        public void SP_IOT_BackEnd_Customer_Factory(string customer_no, string site_code, int factory_no, string factory_name, string address, string phone1, string phone2, string email, string fax, string type,string Station)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Customer_Factory", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("customer_no", customer_no);
            cmd.Parameters.AddWithValue("site_code", site_code);
            cmd.Parameters.AddWithValue("factory_no", factory_no);
            cmd.Parameters.AddWithValue("factory_name", factory_name);
            cmd.Parameters.AddWithValue("address", address);
            cmd.Parameters.AddWithValue("phone1", phone1);
            cmd.Parameters.AddWithValue("phone2", phone2);
            cmd.Parameters.AddWithValue("email", email);
            cmd.Parameters.AddWithValue("fax", fax);
            cmd.Parameters.AddWithValue("type", type);
            cmd.Parameters.AddWithValue("Station", Station);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }

        public void SP_IOT_BackEnd_Customer_Member(string customer_no, string site_code, int factory_no, string username, string role, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Customer_Member", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("customer_no", customer_no);
            cmd.Parameters.AddWithValue("site_code", site_code);
            cmd.Parameters.AddWithValue("factory_no", factory_no);
            cmd.Parameters.AddWithValue("username", username);
            cmd.Parameters.AddWithValue("role", role);
            cmd.Parameters.AddWithValue("type", type);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }


        public void SP_IOT_BackEnd_Main_Machine(string customer_no, string site_code, int factory_no, string main_machine_ID, string main_machine_desc, string main_machine_type, string main_machine_model, string Certificated, string PLC, string Serial_Number, string Remark, int SetPoint_NextDrop, string main_machine_size, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Main_Machine", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("customer_no", customer_no);
            cmd.Parameters.AddWithValue("site_code", site_code);
            cmd.Parameters.AddWithValue("factory_no", factory_no);
            cmd.Parameters.AddWithValue("main_machine_ID", main_machine_ID);
            cmd.Parameters.AddWithValue("main_machine_desc", main_machine_desc);
            cmd.Parameters.AddWithValue("main_machine_type", main_machine_type);
            cmd.Parameters.AddWithValue("main_machine_model", main_machine_model);
            cmd.Parameters.AddWithValue("Certificated", Certificated);
            cmd.Parameters.AddWithValue("PLC", PLC);
            cmd.Parameters.AddWithValue("Serial_Number", Serial_Number);
            cmd.Parameters.AddWithValue("Remark", Remark);
            cmd.Parameters.AddWithValue("SetPoint_NextDrop", SetPoint_NextDrop);
            cmd.Parameters.AddWithValue("main_machine_size", main_machine_size);
            cmd.Parameters.AddWithValue("type", type);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }

        public void SP_IOT_BackEnd_Machine_Alarm_CheckList(string machine_ID, string main_machine_ID, string alarm_ID, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Machine_Alarm_CheckList", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("machine_ID", machine_ID);
            cmd.Parameters.AddWithValue("main_machine_ID", main_machine_ID);
            cmd.Parameters.AddWithValue("alarm_ID", alarm_ID);
            cmd.Parameters.AddWithValue("Status", type);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }

        public void SP_IOT_BackEnd_Machine_RawData_CheckList(string machine_ID, string main_machine_ID, string rawdata_ID, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Machine_RawData_CheckList", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("machine_ID", machine_ID);
            cmd.Parameters.AddWithValue("main_machine_ID", main_machine_ID);
            cmd.Parameters.AddWithValue("rawdata_ID", rawdata_ID);
            cmd.Parameters.AddWithValue("Status", type);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }

        public string SP_IOT_BackEnd_Alarm_mst(string alarm_ID, string alarm_name, string alarm_group, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Alarm_mst", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("alarm_ID", alarm_ID);
            cmd.Parameters.AddWithValue("alarm_name", alarm_name);
            cmd.Parameters.AddWithValue("alarm_group", alarm_group);
            cmd.Parameters.AddWithValue("type", type);
            connect.Open();
            SqlDataReader rs = cmd.ExecuteReader();
            string returnData = "";
            if (rs.Read()) { returnData = rs["ID"].ToString(); }
            connect.Close();
            return returnData;
        }


        public string SP_IOT_BackEnd_RawData_mst(string rawdata_ID, string rawdata_name, string rawdata_group, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_RawData_mst", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("rawdata_ID", rawdata_ID);
            cmd.Parameters.AddWithValue("rawdata_name", rawdata_name);
            cmd.Parameters.AddWithValue("rawdata_group", rawdata_group);
            cmd.Parameters.AddWithValue("type", type);
            connect.Open();
            SqlDataReader rs = cmd.ExecuteReader();
            string returnData = "";
            if (rs.Read()) { returnData = rs["ID"].ToString(); }
            connect.Close();
            return returnData;
        }

        //public void SP_IOT_BackEnd_AlarmLineConfig(string id, string alarm_id, int Seq, int alarm_type, string msg_type, string msg, string prefix, string subfix, int msg_main_type, int PLC, string Status)
        //{
        //    SqlConnection connect = new SqlConnection(connectDB);
        //    SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_AlarmLineConfig", connect);
        //    cmd.CommandType = CommandType.StoredProcedure;
        //    cmd.Parameters.AddWithValue("id", id);
        //    cmd.Parameters.AddWithValue("alarm_id", alarm_id);
        //    cmd.Parameters.AddWithValue("Seq", Seq);
        //    cmd.Parameters.AddWithValue("alarm_type", alarm_type);
        //    cmd.Parameters.AddWithValue("msg_type", msg_type);
        //    cmd.Parameters.AddWithValue("msg", msg);
        //    cmd.Parameters.AddWithValue("prefix", prefix);
        //    cmd.Parameters.AddWithValue("subfix", subfix);
        //    cmd.Parameters.AddWithValue("msg_main_type", msg_main_type);
        //    cmd.Parameters.AddWithValue("PLC", PLC);
        //    cmd.Parameters.AddWithValue("Status", Status);
        //    connect.Open();
        //    cmd.ExecuteNonQuery();
        //    connect.Close();
        //}

        public void SP_IOT_BackEnd_AlarmLineConfig(string id, string alarm_id, int Seq, int alarm_type, string msg_type, string msg, string prefix, string subfix, int msg_main_type, int alarm_group, string PLC, string Status)
        {
            List<String[]> GetData = new List<String[]>();
            SqlConnection connection = new SqlConnection(connectDB);
            string sql = "EXEC SP_IOT_BackEnd_AlarmLineConfig '" + id + "','" + alarm_id + "'," + Seq + "," + alarm_type + ",'" + msg_type + "','" + msg + "','" + prefix + "','" + subfix + "'," + msg_main_type + ",'" + alarm_group + "'," + PLC + ",'" + Status + "'";
            SqlCommand cmd = new SqlCommand(sql, connection);
            connection.Open();
            cmd.ExecuteNonQuery();
            connection.Close();
        }



        public List<String[]> GetUsercontrol()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [username],[name],[lastname],[phone],[email],[Status],[lineToken] FROM [dbo].[TB_User]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[7];
                            Data[0] = reader["username"].ToString().Trim();
                            Data[1] = reader["name"].ToString().Trim();
                            Data[2] = reader["lastname"].ToString().Trim();
                            Data[3] = reader["email"].ToString().Trim();
                            Data[4] = reader["phone"].ToString().Trim();
                            Data[5] = reader["Status"].ToString().Trim();
                            Data[6] = reader["lineToken"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }


        public String SP_IOT_BackEnd_Usercontrol(string username, string name, string lastname, string phone, string email, string Status, string Type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Usercontrol", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("username", username);
            cmd.Parameters.AddWithValue("name", name);
            cmd.Parameters.AddWithValue("lastname", lastname);
            cmd.Parameters.AddWithValue("phone", phone);
            cmd.Parameters.AddWithValue("email", email);
            cmd.Parameters.AddWithValue("Status", Status);
            cmd.Parameters.AddWithValue("Type", Type);
            connect.Open();
            SqlDataReader rs = cmd.ExecuteReader();
            string returnData = "";
            if (rs.Read()) { returnData = rs["ID"].ToString(); }
            connect.Close();
            return returnData;
        }


        public void Reset_Token(string username)
        {
            List<String[]> GetData = new List<String[]>();
            SqlConnection connection = new SqlConnection(connectDB);
            string sql = "UPDATE [dbo].[TB_User]  SET [lineToken] = '' WHERE [username] = '" + username + "'";
            SqlCommand cmd = new SqlCommand(sql, connection);
            connection.Open();
            cmd.ExecuteNonQuery();
            connection.Close();
        }

        public List<String[]> GetListMachine_group()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB))
            {
                string sql = "SELECT [ID], [Code] ,[Name_Group] FROM [dbo].[TB_Machine_Group]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[3];
                            Data[0] = reader["ID"].ToString().Trim();
                            Data[1] = reader["Code"].ToString().Trim();
                            Data[2] = reader["Name_Group"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<String[]> GetListStandardTime()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB_Center))
            {
                string sql = "SELECT TOP (1000) [Monday],[Tuesday],[Wendesday],[Thursday],[Friday],[Saturday],[Sunday],[Effect_date],[ID] FROM [dbo].[VW_Peak_ListStandardTime]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[9];
                            Data[0] = reader["Monday"].ToString().Trim();
                            Data[1] = reader["Tuesday"].ToString().Trim();
                            Data[2] = reader["Wendesday"].ToString().Trim();
                            Data[3] = reader["Thursday"].ToString().Trim();
                            Data[4] = reader["Friday"].ToString().Trim();
                            Data[5] = reader["Saturday"].ToString().Trim();
                            Data[6] = reader["Sunday"].ToString().Trim();
                            Data[7] = reader["Effect_date"].ToString().Trim();
                            Data[8] = reader["ID"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }
        public List<String[]> GetListTimeType()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB_Center))
            {
                string sql = "SELECT [ID],[Type],[Time_Start],[Time_End] FROM [dbo].[TB_Peak_TimeType]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[4];
                            Data[0] = reader["ID"].ToString().Trim();
                            Data[1] = reader["Type"].ToString().Trim();
                            Data[2] = reader["Time_Start"].ToString().Trim();
                            Data[3] = reader["Time_End"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }
        public List<String[]> GetListSpecialTime()
        {
            List<String[]> GetData = new List<String[]>();
            using (SqlConnection connection = new SqlConnection(connectDB_Center))
            {
                string sql = "SELECT [ID],[Special_Date],[TimeType] FROM [dbo].[VW_Peak_SpecialTime]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[3];
                            Data[0] = reader["ID"].ToString().Trim();
                            Data[1] = reader["Special_Date"].ToString().Trim();
                            Data[2] = reader["TimeType"].ToString().Trim();
                            GetData.Add(Data);
                        }
                    }
                }
            }
            return GetData;
        }

        public void SP_IOT_Peak_StandardTime(string mon, string tues, string wend, string thurs, string fri, string sat, string sun, string effDate)
        {
            SqlConnection connect = new SqlConnection(connectDB_Center);
            SqlCommand cmd = new SqlCommand("SP_IOT_Peak_StandardTime", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("Monday", mon);
            cmd.Parameters.AddWithValue("Tuesday", tues);
            cmd.Parameters.AddWithValue("Wendesday", wend);
            cmd.Parameters.AddWithValue("Thursday", thurs);
            cmd.Parameters.AddWithValue("Friday", fri);
            cmd.Parameters.AddWithValue("Saturday", sat);
            cmd.Parameters.AddWithValue("Sunday", sun);
            cmd.Parameters.AddWithValue("Effect_date", effDate);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }

        public void SP_IOT_Peak_SpecialTime(int ID, string specialDate, string timeTypeSpecial, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB_Center);
            SqlCommand cmd = new SqlCommand("SP_IOT_Peak_SpecialTime", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("ID", ID);
            cmd.Parameters.AddWithValue("Special_Date", specialDate);
            cmd.Parameters.AddWithValue("TimeType", timeTypeSpecial);
            cmd.Parameters.AddWithValue("Status", type);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }

        public void SP_IOT_Peak_TimeType(string typeName, string timeStart, string timeEnd, int index)
        {
            SqlConnection connect = new SqlConnection(connectDB_Center);
            SqlCommand cmd = new SqlCommand("SP_IOT_Peak_TimeType", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("Type", typeName);
            cmd.Parameters.AddWithValue("Time_Start", timeStart);
            cmd.Parameters.AddWithValue("Time_End", timeEnd);
            cmd.Parameters.AddWithValue("Times", index);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
        }


    }
}