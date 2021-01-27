package main

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"runtime"
	"time"

	"learn/queue"
)

func init() {
	runtime.GOMAXPROCS(4)
}

func main() {
	err := queue.Start()
	if err != nil {
		log.Fatal(err)
	}

	http.HandleFunc("/index/hello1", hello1)
	http.HandleFunc("/index/hello2", hello2)
	http.HandleFunc("/index/hello3", hello3)
	http.HandleFunc("/index/hello4", hello4)
	http.HandleFunc("/index/hello5", hello5)
	http.HandleFunc("/index/hello6", hello6)
	err = http.ListenAndServe(":9090", nil)
	if err != nil {
		fmt.Printf("http server failed, err:%v\n", err)
		return
	}
}

func hello1(w http.ResponseWriter, r *http.Request) {
	print(r,"hello1")
}

func hello2(w http.ResponseWriter, r *http.Request) {
	print(r,"hello2")
}

func hello3(w http.ResponseWriter, r *http.Request) {
	print(r,"hello3")
}

func hello4(w http.ResponseWriter, r *http.Request) {
	print(r,"hello4")
}

func hello5(w http.ResponseWriter, r *http.Request) {
	print(r,"hello5")
}

func hello6(w http.ResponseWriter, r *http.Request) {
	print(r,"hello6")
}

func print(r *http.Request,uri string)  {
	var queueMsg queue.Asyncqueue
	if err := json.NewDecoder(r.Body).Decode(&queueMsg); err != nil {
		r.Body.Close()
		log.Fatal(err)
	}
	fmt.Println(time.Now().Format("2006-01-02 15:04:05"),"uri:",uri , "serviceId:" ,queueMsg.ServiceId,"foreignId",queueMsg.ForeignId)
}

