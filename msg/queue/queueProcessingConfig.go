package queue

import (
	"io/ioutil"
	"os"
	"sync"

	"github.com/BurntSushi/toml"
)

type Config struct {
	Servers map[string]Server
}

type Server struct {
	ServiceId int
	Callback string
	Concurrency int
}

var ConfigOnce sync.Once
var ConfigInstance *Config

func getConf() *Config {
	ConfigOnce.Do(func() {
		ConfigInstance = new(Config)
	})
	return ConfigInstance
}

func LoadSingle(confPath string) (*Config, error) {
	conf := getConf()
	data := make([]byte, 0)
	if _, err := os.Stat(confPath); os.IsNotExist(err) {
		return nil,err
	}

	cnfData, err := ioutil.ReadFile(confPath)
	if err != nil {
		return nil,err
	}

	data = append(data, cnfData...)
	data = append(data, '\n')
	err = toml.Unmarshal(data, &conf)
	if err != nil {
		return nil, err
	}
	return conf, nil
}

