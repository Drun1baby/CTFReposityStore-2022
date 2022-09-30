package main

import (
	"github.com/buger/jsonparser"
    "fmt"
	"net/http"
    "io/ioutil"
    "io"
)

func pay(w http.ResponseWriter, r *http.Request) {
    var cost int64 = 0
	var err1 int64 = 0
    json, _ := ioutil.ReadAll(r.Body)
	secret, err := jsonparser.GetString(json, "secret")
	if err != nil {
        fmt.Println(err)
    }
	if secret != "xxxx"{   //secret已打码
		io.WriteString(w, "{\"error\": \"secret error\"}")
		return
	}
	money, err := jsonparser.GetInt(json, "money")
	if err != nil {
        fmt.Println(err)
    }
	_, err = jsonparser.ArrayEach(
			json,
            func(value []byte, dataType jsonparser.ValueType, offset int, err error) {
                id, _ := jsonparser.GetInt(value, "id")
                num, _ := jsonparser.GetInt(value, "num")
				if id == 1{
					cost = cost + 200 * num
				}else if id == 2{
					cost = cost + 1000 * num
				}else{
					err1 = 1
				}
            },
        "product")
	if err != nil {
		fmt.Println(err)
	}
	if err1 == 1{
		io.WriteString(w, "{\"error\": \"id error\"}")
		return
	}
	if cost > money{
		io.WriteString(w, "{\"error\": \"Sorry, your credit is running low!\"}")
		return
	}
	money = money - cost
    io.WriteString(w, fmt.Sprintf("{\"error\":0,\"money\": %d}", money))
}

func main() {
    mux := http.NewServeMux()
    mux.HandleFunc("/pay", pay)
    http.ListenAndServe(":10002", mux)
}
