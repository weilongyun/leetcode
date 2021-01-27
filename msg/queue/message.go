package queue

import (
	"encoding/json"
	"time"
)

func init()  {

}

const max = 1

type MsgManager struct {
	Ch chan *Asyncqueue
}

func newReceiversManager() *MsgManager {
	 manager := &MsgManager{}
	 manager.Ch = make(chan *Asyncqueue)
	 return manager
}

func (manager *MsgManager)PullServiceIdMsgs(serverConfig *Server) {
	//测试数据
	text := new(Asyncqueue)
	text.Context = ""
	text.ServiceId = 1
	text.ForeignId = 2

	for {
		if len(manager.Ch) > max {
			time.Sleep(time.Duration(500)*time.Microsecond)
		}
		//查数据
		manager.Ch <- text
	}
}

func (manager *MsgManager)PushServiceIdMsgs(serverConfig *Server) {
	var jsonstr []byte
	var err error
	for msg := range manager.Ch {
		if  jsonstr,err = json.Marshal(msg); err != nil {
			panic("json Marshal error:" + err.Error())
		}
		HttpPost(serverConfig.Callback,"",string(jsonstr))
	}
}
