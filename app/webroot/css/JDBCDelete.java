import java.sql.*;
import java.io.*;
import javax.servlet.http.*;
import javax.servlet.*;

public class JDBCDelete  extends HttpServlet{
    public void doPost(HttpServletRequest request, HttpServletResponse response)
    throws IOException, ServletException{
        response.setContentType("text/html");
      response.setCharacterEncoding("utf-8");
      request.setCharacterEncoding("utf-8");
      PrintWriter out = response.getWriter();
    try {
	String pref = request.getParameter("pref");
	String city = request.getParameter("city");
        out.println("<html>");
        out.println("<body>");
      // Load MySQL JDBC driver class
      Class.forName("org.gjt.mm.mysql.Driver");

      // Connect to the daatabase
	  String url = "jdbc:mysql://localhost/sit?user=testaccount&password=sendouteki";
      Connection con = DriverManager.getConnection(url);

      // Create a statement object
      Statement stmt = con.createStatement();
	  String sql = "Delete from city where pref='"+pref+"' and city='"+city"' ";
	  
      // Execute the query
	  int rs;
      rs = stmt.executeUpdate(sql);
      // Fetch the tuples
      /*while(rs.next()){
        String pref = rs.getString("pref");
        String city = rs.getString("city");
        out.println(pref + " " + city);
      }*/
      // Disconnect from the database
      stmt.close();
      con.close();
	  out.println("データを削除ました");
	  out.println("<a href='/myservlet/sayhello'>戻る</a>");
      out.println("</body>");
      out.println("</html>");
    } catch (Exception e) {
      e.printStackTrace();
        out.println(e.toString());
    }
  }
}