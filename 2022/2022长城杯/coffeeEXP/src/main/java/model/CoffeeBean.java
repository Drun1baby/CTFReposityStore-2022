package model;//
// Source code recreated from a .class file by IntelliJ IDEA
// (powered by FernFlower decompiler)
//



import java.io.Serializable;

public class CoffeeBean extends ClassLoader implements Serializable {
    private String name = "Coffee bean";
    private byte[] ClassByte;

    public String getName() {
        return this.name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public CoffeeBean() {
    }

    public String toString() {
        CoffeeBean coffeeBean = new CoffeeBean();
        Class clazz = coffeeBean.defineClass((String)null, this.ClassByte, 0, this.ClassByte.length);
        Object var3 = null;

        try {
            var3 = clazz.newInstance();
        } catch (InstantiationException var5) {
            var5.printStackTrace();
        } catch (IllegalAccessException var6) {
            var6.printStackTrace();
        }

        return "A cup of Coffee --";
    }
}
