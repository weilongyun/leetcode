package queue

import (
	"io"
	"io/ioutil"
	"log"
	"net"
	"net/http"
	"runtime"
	"strings"
	"sync"
	"time"
)

var (
	httpClient *http.Client
)

func init() {
	httpClient = createHTTPClient()
}

var (
	httpInstance *http.Client
	once         sync.Once
)

func createHTTPClient() *http.Client {
	once.Do(func() {
		httpInstance = &http.Client{
			Timeout: 1 * time.Second,
			Transport: &http.Transport{
				DialContext: (&net.Dialer{
					Timeout:   2 * time.Second,
					KeepAlive: 60 * time.Second,
				}).DialContext,
				MaxIdleConns:        1000,
				MaxIdleConnsPerHost: 1000,
				IdleConnTimeout:     90 * time.Second,
			},
		}
	})
	return httpInstance
}

// https://studygolang.com/articles/12720
func HttpPost(url, host, data string) {
	defer func() {
		if e := recover(); e != nil {
			buf := make([]byte, 4096)
			n := runtime.Stack(buf, false)
			log.Printf("HttpReq error: [%s],stack: [%s]", e,
				strings.Replace(string(buf[0:n]), "\n", "", -1))
		}
	}()

	req, err := http.NewRequest("POST", url, strings.NewReader(data))
	checkError(err)

	if req.Host != "" {
		req.Host = host
	}
	req.Header.Set("Content-Type", "application/json")

	resp, err := httpClient.Do(req)
	if err != nil {
		log.Printf("http err %s", err)
		return
	}
	io.Copy(ioutil.Discard, resp.Body)
	resp.Body.Close()
}

func checkError(err error) bool {
	if err != nil {
		log.Printf("err %s", err)
		return false
	}
	return true
}
