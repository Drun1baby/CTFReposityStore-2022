package main

import (
	"bytes"
	"crypto/tls"
	"fmt"
	"io/ioutil"
	"net/http"
)

func httpRequest(targetUrl string, method string) *http.Response {

	request, error := http.NewRequest(method, targetUrl, bytes.NewBuffer([]byte(nil)))

	customTransport := &http.Transport{
		TLSClientConfig: &tls.Config{InsecureSkipVerify: true},
	}
	client := &http.Client{Transport: customTransport}
	response, error := client.Do(request)
	defer response.Body.Close()

	if error != nil {
		panic(error)
	}

	body, _ := ioutil.ReadAll(response.Body)
	fmt.Println("response Status:", response.Status)
	fmt.Println("response Body:", string(body))
	return response
}
