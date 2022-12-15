package model;//
// Source code recreated from a .class file by IntelliJ IDEA
// (powered by FernFlower decompiler)
//


import model.CoffeeBean;

public class CoffeeModel implements Venti {
    double chocolate = 0.2D;
    double suger = 0.1D;
    private String name = "Coffee";
    private CoffeeBean coffeeBean;

    public CoffeeModel() {
    }

    public double getChocolate() {
        return this.chocolate;
    }

    public void setChocolate(double chocolate) {
        this.chocolate = chocolate;
    }

    public double getSuger() {
        return this.suger;
    }

    public void setSuger(double suger) {
        this.suger = suger;
    }

    public String getcoffeeName() {
        return this.name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public CoffeeBean getCoffeeBean() {
        return this.coffeeBean;
    }

    public void setCoffeeBean(CoffeeBean coffeeBean) {
        this.coffeeBean = coffeeBean;
    }

    public int getSize() {
        return 1;
    }
}
