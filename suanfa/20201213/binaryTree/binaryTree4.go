/**
@desc weilongyun
@date :20201213
*/

package main

import "fmt"
/*type TreeNode struct {
	Val int
	Left *TreeNode
	Right *TreeNode
}*/
//非递归的方式
/*func kthLargest(root *TreeNode, k int) int {
	var stack [](*TreeNode)
	node := root

	for len(stack)!=0||node!=nil {
		if node != nil {
			stack = append(stack, node)
			node = node.Right
		}else {
			node = stack[len(stack)-1]
			k-- //遍历点
			if k == 0 {
				break
			}//endif
			stack = stack[:len(stack)-1]
			node = node.Left
		}//endif
	}//endfor

	return node.Val
}*/

func main(){

	//构造一颗二叉搜索数
	var root *TreeNode = new(TreeNode)
	root.Val = 5
	var s1 *TreeNode = new(TreeNode)
	s1.Val = 3
	root.Left = s1

	var s2 *TreeNode = new(TreeNode)
	s2.Val = 6
	root.Right = s2

	var s3 *TreeNode = new(TreeNode)
	s3.Val = 2
	s1.Left = s3

	var s4 *TreeNode = new(TreeNode)
	s4.Val = 4
	s1.Right = s4

	var s5 *TreeNode = new(TreeNode)
	s5.Val = 1
	s3.Left = s5
	fmt.Println(s2.Left)
	value := kthLargest(root,3)
	fmt.Printf("第k大的值为 %d",value)
}

