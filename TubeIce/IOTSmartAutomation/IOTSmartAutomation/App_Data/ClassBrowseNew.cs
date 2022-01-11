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
        //public static String connectDB = "Data Source=172.25.238.2;Initial Catalog=IOTPatkol;Persist Security Info=True;User ID=sa;Password=@Patkol.com; Connect Timeout=0; pooling=true; Max Pool Size=50000";
        public static String connectDB = "Data Source=203.151.62.137;Initial Catalog=IOTPatkol;Persist Security Info=True;User ID=sa;Password=@Patkol.com; Connect Timeout=0; pooling=true; Max Pool Size=50000";

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
                string sql = "SELECT [username] FROM [dbo].[TB_User] WHERE [lineToken] = '" + LineToken + "'";
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
                string sql = "SELECT [main_machine_ID] ,[main_machine_desc] ,[main_machine_type] ,[Certificated] ,[PLC] ,[SetPoint_NextDrop] FROM [dbo].[TB_MainMachine] WHERE [customer_no] = '" + CustomerNo + "' AND [site_code] = '" + site_code + "' AND [factory_no] = '" + factory_no + "'";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[6];
                            Data[0] = reader["main_machine_ID"].ToString().Trim();
                            Data[1] = reader["main_machine_desc"].ToString().Trim();
                            Data[2] = reader["main_machine_type"].ToString().Trim();
                            Data[3] = reader["Certificated"].ToString().Trim();
                            Data[4] = reader["PLC"].ToString().Trim();
                            Data[5] = reader["SetPoint_NextDrop"].ToString().Trim();
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
                string sql = "SELECT [alarm_ID],[alarm_name],[alarm_Msg] FROM [dbo].[TB_Alarm_mst]";
                using (SqlCommand cmd = new SqlCommand(sql, connection))
                {
                    connection.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            String[] Data = new String[3];
                            Data[0] = reader["alarm_ID"].ToString().Trim();
                            Data[1] = reader["alarm_name"].ToString().Trim();
                            Data[2] = reader["alarm_Msg"].ToString().Trim();
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
                string sql = "SELECT [rawdata_ID] ,[rawdata_name] FROM [dbo].[TB_TubeIce_RawData_mst]";
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
                            String[] Data = new String[10];
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


        public void SP_IOT_BackEnd_Main_Machine(string customer_no, string site_code, int factory_no, string main_machine_ID, string main_machine_desc, string main_machine_type, string main_machine_model, string Certificated, string PLC, string Serial_Number, string Remark, int SetPoint_NextDrop, string type)
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

        public string SP_IOT_BackEnd_Alarm_mst(string alarm_ID, string alarm_name,int alarm_Msg, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_Alarm_mst", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("alarm_ID", alarm_ID);
            cmd.Parameters.AddWithValue("alarm_name", alarm_name);
            cmd.Parameters.AddWithValue("alarm_Msg", alarm_Msg);
            cmd.Parameters.AddWithValue("type", type);
            connect.Open();
            SqlDataReader rs = cmd.ExecuteReader();
            string returnData = "";
            if (rs.Read()) { returnData = rs["ID"].ToString(); }
            connect.Close();
            return returnData;
        }


        public string SP_IOT_BackEnd_RawData_mst(string rawdata_ID, string rawdata_name, string type)
        {
            SqlConnection connect = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_IOT_BackEnd_RawData_mst", connect);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("rawdata_ID", rawdata_ID);
            cmd.Parameters.AddWithValue("rawdata_name", rawdata_name);
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

        public void SP_IOT_BackEnd_AlarmLineConfig(string id, string alarm_id, int Seq, int alarm_type, string msg_type, string msg, string prefix, string subfix, int msg_main_type, string PLC, string Status)
        {
            List<String[]> GetData = new List<String[]>();
            SqlConnection connection = new SqlConnection(connectDB);
            string sql = "EXEC SP_IOT_BackEnd_AlarmLineConfig '" + id + "','" + alarm_id + "'," + Seq + "," + alarm_type + ",'" + msg_type + "','" + msg + "','" + prefix + "','" + subfix + "'," + msg_main_type + "," + PLC + ",'" + Status + "'";
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

        public List<ArrayList> GET_TB_Package()
        {
            List<ArrayList> GetData = new List<ArrayList>();
            using (SqlConnection conn = new SqlConnection(connectDB))
            {
                string sql = "SELECT [PackageCode],[PackageName] FROM [IOTPatkol].[dbo].[TB_Package]";
                using (SqlCommand cmd = new SqlCommand(sql, conn))
                {
                    cmd.CommandTimeout = 300;
                    conn.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            ArrayList detail = new ArrayList();
                            for (int i = 0; i < reader.FieldCount; i++)
                            {
                                detail.Add(reader[i].ToString());
                            }
                            GetData.Add(detail);
                        }
                    }
                }
            }
            return GetData;
        }
        public string SP_Package(string PackageCode, string PackageName, string Status)
        {
            SqlConnection con = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_Package", con);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("PackageCode", PackageCode);
            cmd.Parameters.AddWithValue("PackageName", PackageName);
            cmd.Parameters.AddWithValue("Status", Status);
            con.Open();
            //cmd.ExecuteNonQuery();
            SqlDataReader rs = cmd.ExecuteReader();
            string returnData = "";
            if (rs.Read())
            {
                returnData = rs["Msg"].ToString();
            }
            con.Close();
            return returnData;
        }

        public List<ArrayList> GET_VW_Customer_Package(string customer_no)
        {
            List<ArrayList> GetData = new List<ArrayList>();
            using (SqlConnection conn = new SqlConnection(connectDB))
            {
                string sql = "SELECT [customer_no],[PackageCode],[PackageName],[Active_date],[Expire_date] " +
                    "FROM [dbo].[VW_Customer_Package] " +
                    "WHERE [customer_no] = '"+ customer_no + "'";
                using (SqlCommand cmd = new SqlCommand(sql, conn))
                {
                    cmd.CommandTimeout = 300;
                    conn.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            ArrayList detail = new ArrayList();
                            for (int i = 0; i < reader.FieldCount; i++)
                            {
                                detail.Add(reader[i].ToString());
                            }
                            GetData.Add(detail);
                        }
                    }
                }
            }
            return GetData;
        }

        public List<ArrayList> GET_Customer_Package(string notin,string search)
        {
            List<ArrayList> GetData = new List<ArrayList>();
            using (SqlConnection conn = new SqlConnection(connectDB))
            {
                string sql = "SELECT [PackageCode],[PackageName] FROM [IOTPatkol].[dbo].[TB_Package] ";
                sql += "WHERE 1=1 ";
                if(notin != "")
                {
                   sql+= " AND [PackageCode] not in (" + notin + ") ";
                }
                if(search != "")
                {
                    sql+= " AND [PackageCode] ='"+ search + "'";
                }

                using (SqlCommand cmd = new SqlCommand(sql, conn))
                {
                    cmd.CommandTimeout = 300;
                    conn.Open();
                    using (var reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            ArrayList detail = new ArrayList();
                            for (int i = 0; i < reader.FieldCount; i++)
                            {
                                detail.Add(reader[i].ToString());
                            }
                            GetData.Add(detail);
                        }
                    }
                }
            }
            return GetData;
        }
        public string SP_Customer_Package(string customer_no, string PackageCode,
            string Active_date, string Expire_date, string Status)
        {
            SqlConnection con = new SqlConnection(connectDB);
            SqlCommand cmd = new SqlCommand("SP_Customer_Package", con);
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.Parameters.AddWithValue("customer_no", customer_no);
            cmd.Parameters.AddWithValue("PackageCode", PackageCode);
            cmd.Parameters.AddWithValue("Active_date", Active_date);
            cmd.Parameters.AddWithValue("Expire_date", Expire_date);
            cmd.Parameters.AddWithValue("Status", Status);
            con.Open();
            //cmd.ExecuteNonQuery();
            SqlDataReader rs = cmd.ExecuteReader();
            string returnData = "";
            if (rs.Read())
            {
                returnData = rs["Msg"].ToString();
            }
            con.Close();
            return returnData;
        }


    }
}