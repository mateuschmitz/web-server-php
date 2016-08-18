import java.io.*;

public class Server { 
    public static void main(String args[]){ 
        try {
            Runtime.getRuntime().exec("php -S 127.0.0.1:8085 -t www/");
        } catch(IOException e) {
            System.err.println("Deu merda...");
            e.printStackTrace();  
        }
    } 
}
