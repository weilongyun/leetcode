package tree

import (
	"fmt"
	"math"
)

type Tree struct {
	Root * TreeNode
}

func (self * Tree)TreeAdd(num int)  {
	node := new(TreeNode)
	node.Value = num

	if self.Root == nil {
		self.Root = node
		return
	}

	var queue []* TreeNode
	queue = append(queue,self.Root)//保存遍历到的节点
	queuelen := 1
	for (queuelen != 0) {
		nowNode := queue[0]
		queue = append(queue[:0],queue[0+1:]...)
		if num > nowNode.Value {
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

/*
 	前序遍历的顺序是  根 -----> 左子树 -----> 右子树
*/

func (tree *Tree)Qian(node *TreeNode) {
	if node == nil {
		return
	}
	fmt.Print(node.Value , " ")
	tree.Qian(node.Left)
	tree.Qian(node.Right)
}

/*
	前序遍历的顺序是  左 -----> 根 -----> 右
*/
func (tree *Tree)Zhong(node *TreeNode) {
	if node == nil {
		return
	}
	tree.Zhong(node.Left)
	fmt.Print(node.Value , " ")
	tree.Zhong(node.Right)
}

/*
	前序遍历的顺序是  左 -----> 右 -----> 根
*/

func (tree *Tree)Hou(node *TreeNode) {
	if node == nil {
		return
	}
	tree.Hou(node.Left)
	tree.Hou(node.Right)
	fmt.Print(node.Value , " ")
}

func (tree *Tree)Height(node *TreeNode) float64 {
	if node == nil {
		return  0;

	}
	return math.Max(tree.Height(node.Left) , tree.Height(node.Right)) + 1
}