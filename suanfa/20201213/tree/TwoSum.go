package tree

import (
	"container/list"
)

type TreeTowSumNode struct {
	Value       int
	Index		int
	Left, Right * TreeTowSumNode
}

type TreeTowSum struct {
	Root * TreeTowSumNode
}

func (self *TreeTowSum) treeAdd (value int ,index int)  {
	node := new(TreeTowSumNode)
	node.Value = value
	node.Index = index

	if self.Root == nil {
		self.Root = node
		return
	}

	var queue []* TreeTowSumNode
	queue = append(queue,self.Root)//保存遍历到的节点
	queuelen := 1
	for (queuelen != 0) {
		nowNode := queue[0]
		queue = append(queue[:0],queue[0+1:]...)
		if value > nowNode.Value {
			if nowNode.Right == nil {
				nowNode.Right = node
			}else {
				queue = append(queue,nowNode.Right)
			}
		}else {
			if nowNode.Left == nil {
				nowNode.Left = node
			}else {
				queue = append(queue,nowNode.Left)
			}
		}
		queuelen = len(queue)
	}

	return
}

func (self *TreeTowSum) find (value int,index int) int {
	queue := list.New()
	queue.PushBack(self.Root)

	for queue.Len() != 0 {
		queueNode, _ := queue.Front().Value.(*TreeTowSumNode)
		if queueNode.Value == value && queueNode.Index != index{
			return queueNode.Index
		}
		queue.Remove(queue.Front())
		if queueNode.Left != nil {
			queue.PushBack(queueNode.Left)
		}
		if queueNode.Right != nil {
			queue.PushBack(queueNode.Right)
		}
	}

	return -1
}

/*
	https://leetcode-cn.com/problems/two-sum/
	树算法
*/

func TwoSum(nums []int, target int) []int {
	tree := TreeTowSum{}
	var res = make([]int,0)
	var index int

	for index, value := range nums {
		tree.treeAdd(value,index)
	}

	for idx, value := range nums {
		index = tree.find(target - value,idx)
		if index < 0 || idx == index {
			continue
		}
		res = append(res,idx)
		res = append(res,index)
		return res
 	}
 	return res
}

/*
	https://leetcode-cn.com/problems/two-sum/
	官方算法
*/

func twoSum(nums []int, target int) []int {
	hashTable := map[int]int{}
	for i, x := range nums {
		if p, ok := hashTable[target-x]; ok {
			return []int{p, i}
		}
		hashTable[x] = i
	}
	return nil
}

