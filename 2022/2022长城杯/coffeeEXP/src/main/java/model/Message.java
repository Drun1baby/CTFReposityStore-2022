package model;//
// Source code recreated from a .class file by IntelliJ IDEA
// (powered by FernFlower decompiler)
//



public class Message {
    int code;
    String detail;
    Object data;

    public Message(int code, String detail) {
        this.code = code;
        this.detail = detail;
    }

    public Message(int code, String detail, Object data) {
        this.code = code;
        this.detail = detail;
        this.data = data;
    }

    public int getCode() {
        return this.code;
    }

    public String getDetail() {
        return this.detail;
    }

    public Object getData() {
        return this.data;
    }

    public void setCode(final int code) {
        this.code = code;
    }

    public void setDetail(final String detail) {
        this.detail = detail;
    }

    public void setData(final Object data) {
        this.data = data;
    }
}
