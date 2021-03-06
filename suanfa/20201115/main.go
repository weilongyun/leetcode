/**
  @desc https://leetcode-cn.com/problems/linked-list-cycle-lcci/
  @author 田力
  @date  2020-11-15
*/
package main

import (
	"leetcode/suanfa/20201115/three"
	"fmt"
)

// 环路检测
func main() {
	head := three.CreRingRoadList()
	head.PrintList()
	isRR := three.IsRingRoadLists(head)
	if isRR != nil {
		fmt.Printf("环路链表切入节点地址为：%p", isRR)
	} else {
		fmt.Printf("head链表不是一个环路链表")
	}
}
