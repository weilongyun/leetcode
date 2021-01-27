package queue

import (
	"log"
	"os"
	"sync"
)

func Start() error{
	current,_ := os.Getwd();
	fileName := current + "//config//service.toml"
	config,err := LoadSingle(fileName)
	if err != nil {
		return err
	}

	if len(config.Servers) == 0 {
		log.Fatal("加载配置失败")
	}

	var waitGroup sync.WaitGroup

	for _,server:= range config.Servers {
		waitGroup.Add(1)
		serverNew := server
		go func() {
			consumer(&serverNew,&waitGroup);
		}()
	}

	waitGroup.Wait()
	return nil
}

func consumer(server *Server, wait *sync.WaitGroup)  (err error) {
	defer func() {
		wait.Done()
	}()

	if server.Concurrency == 0 || server.ServiceId == 0 {
		panic("serviceId and concurrency error")
	}

	manager := newReceiversManager()
	go func() {
		manager.PullServiceIdMsgs(server)
	}()

	for i := 0 ; i < server.Concurrency ;i++ {
		go func() {
			manager.PushServiceIdMsgs(server)
		}()
	}

	return
}

