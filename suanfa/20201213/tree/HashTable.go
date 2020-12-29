package tree

import (
	"fmt"
)

type tableNode struct {
	val int
	next *tableNode
}

const SIZE = 10

type HashTable struct {
	Table map[int] * tableNode
	size int
}

func NewHashTable() *HashTable{
	hash := make(map[int]*tableNode, SIZE);
	return &HashTable{hash,SIZE}
}

func (hash *HashTable)Create(value int)  {
	index := hashFunction(value,hash.size)
	node := new(tableNode)
	node.val = value
	node.next = hash.Table[index]
	hash.Table[index] = node
}

func hashFunction(i int ,size int) int {
	return (i % size)
}

func (hash *HashTable)Print()  {
	if hash == nil {
		return
	}

	for k,_ := range hash.Table {
		node :=  hash.Table[k]
		for node != nil {
			fmt.Print(node.val,"\t")
			node = node.next
		}
		fmt.Print("\n")
  	}
}

