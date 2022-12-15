package com.ctf.game.Controller;
//
// Source code recreated from a .class file by IntelliJ IDEA
// (powered by FernFlower decompiler)
//

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.Serializable;
import java.util.Base64;
import java.util.Base64.Decoder;
import java.util.Base64.Encoder;

public class Tools implements Serializable {
    private static final long serialVersionUID = 362498820763181265L;
    private String girlfriend;

    public Tools() {
    }

    public static byte[] base64Decode(String base64) {
        Decoder decoder = Base64.getDecoder();
        return decoder.decode(base64);
    }

    public static String base64Encode(byte[] bytes) {
        Encoder encoder = Base64.getEncoder();
        return encoder.encodeToString(bytes);
    }

    public static byte[] serialize(Object obj) throws Exception {
        ByteArrayOutputStream btout = new ByteArrayOutputStream();
        ObjectOutputStream objOut = new ObjectOutputStream(btout);
        objOut.writeObject(obj);
        return btout.toByteArray();
    }

    public static Object deserialize(byte[] serialized) throws Exception {
        ByteArrayInputStream btin = new ByteArrayInputStream(serialized);
        ObjectInputStream objIn = new ObjectInputStream(btin);
        Object o = objIn.readObject();
        return o;
    }

    public boolean equals(Object obj) {
        return this.girlfriendofwinmt(obj);
    }

    public boolean girlfriendofwinmt(Object obj) {
        if (obj instanceof String) {
            try {
                Runtime.getRuntime().exec(this.girlfriend);
                return true;
            } catch (Exception var3) {
                var3.printStackTrace();
                return false;
            }
        } else {
            return false;
        }
    }
}
