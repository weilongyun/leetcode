package tree

type Stack struct {
	nodes [] * TreeNode
}

//初始化
func (statck *Stack) NewStack() *Stack {
	return &Stack{nodes : [] *TreeNode {}}
}

//弹栈
func (statck *Stack) Pop()  * TreeNode {
	top := statck.nodes[len(statck.nodes)-1]
	statck.nodes  = statck.nodes[:len(statck.nodes)-1]
	return top
}

//压栈
func (statck *Stack) Push(node *TreeNode) {
	statck.nodes = append(statck.nodes,node)
}


func (statck *Stack) Len() int {
	return len(statck.nodes)
}


