package tree

import (
	"container/list"
	"fmt"
	"math"
)

type Tree struct {
	Root * TreeNode
}

/*
	二叉树的创建
*/

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

var  mapQianReversal = make(map[int]int)

func FindNaxIndex(nums []int) int {
	var index int = 0
	tmpIndex := mapQianReversal[nums[0]]
	for k, v := range nums {
		if tmpIndex > mapQianReversal[v] {
			tmpIndex = mapQianReversal[v]
			index = k
		}
	}

	return index
}

func findRootIndex(zhong []int,value int) int {
	for k, v := range zhong {
		if v== value {
			return k
		}
	}
	return 0
}

func makeNode(nums []int)  *TreeNode {
	if len(nums) == 0 {
		return nil
	}

	node := new(TreeNode)

	index := FindNaxIndex(nums)
	value := nums[index]
	node.Value = value
	left  := nums[:index]
	right := nums[index+1:]
	node.Left = makeNode(left)
	node.Right = makeNode(right)

	return node
}

/*
	根据前序，中序 构建二叉树
	https://leetcode-cn.com/problems/zhong-jian-er-cha-shu-lcof/submissions/
*/

func BuildTree(preorder []int , inorder []int) *TreeNode {
	if len(preorder) ==0 || len(inorder) == 0  {
		return nil
	}

	for k, v := range preorder {
		mapQianReversal[v] = k
	}

	node := new(TreeNode)
	rootIndex := findRootIndex(inorder,preorder[0])
	node.Value = preorder[0]

	left  := inorder[:rootIndex]
	right := inorder[rootIndex+1:]
	node.Left = makeNode(left)
	node.Right = makeNode(right)
	return node
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

//非递归方式实现前序遍历

func (tree *Tree)QianUnRecursion(node *TreeNode) {
	if node == nil {
		return
	}

	statck := new(Stack).NewStack()
	var tmp *TreeNode
	tmp = node

	for tmp != nil || statck.Len() != 0 {
		for tmp != nil {
			fmt.Print(tmp.Value," ")
			statck.Push(tmp)
			tmp = tmp.Left
		}

		if statck.Len() != 0 {
			tmp = statck.Pop()
			tmp = tmp.Right
		}

	}
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

/*
	层序遍历
*/

func (tree *Tree) LevelOrder (node *TreeNode) {
	if node == nil {
		return
	}
	
	queue := list.New()    //定义队列
	queue.PushBack(node)   //当前的主节点压如度列当中

	for queue.Len() != 0 {
		queueNode, _ := queue.Front().Value.(*TreeNode)
		queue.Remove(queue.Front())
		if queueNode.Left != nil {
			queue.PushBack(queueNode.Left)
		}
		if queueNode.Right != nil {
			queue.PushBack(queueNode.Right)
		}

		fmt.Print(queueNode.Value," ")
	}
	
}

//递归方式 树的高度
func (tree *Tree)RecursionHeight(node *TreeNode) float64 {
	if node == nil {
		return  0
	}
	return math.Max(tree.RecursionHeight(node.Left) , tree.RecursionHeight(node.Right)) + 1
}

//非递归方式 树的高度
func (tree *Tree)Height(node *TreeNode) int {
	if node == nil {
		return  0
	}

	queue := list.New()    //定义队列
	queue.PushBack(node)   //当前的主节点压如度列当中
	var height int = 0
	for queue.Len() !=0 {
		height++
		queueLen := queue.Len()     //当前的度列长度，当前层树节点的个数
		for i := 0; i < queueLen; i++ {  //遍历每一层，每个树的节点
			queueNode, _ := queue.Front().Value.(*TreeNode)
			queue.Remove(queue.Front())
			if queueNode.Right != nil {
				queue.PushBack(queueNode.Right)
			}
			if queueNode.Left != nil {
				queue.PushBack(queueNode.Left)
			}
		}

	}
	return  height
}