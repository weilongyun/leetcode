package tree

/*
	字典树
*/

type Trie struct {
	isEnd bool
	next [26]*Trie
}

var chars []byte  = []byte("abcdefghijklmnopqrstuvwxyz")

func NewTrie() *Trie{
	return &Trie{}
}

//添加节点
func (this*Trie)Insert(word string)  {
	node := this
	for _,v := range word {
		if node.next[v - 'a'] == nil {
			node.next[v - 'a'] = new(Trie)
		}
		node = node.next[v - 'a']
	}
	node.isEnd = true
}

//查询字符串 全匹配
func (this*Trie)Sreach(word string) bool {
	tire := this
	for _,v := range word {
		if tire.next[v - 'a'] == nil {
			return false
		}else {
			tire = tire.next[v - 'a']
		}
	}
	return tire.isEnd == true
}

//查询所有节点
func (this*Trie)SreachAll(prefix string)[]string {
	tire := this
	var res []string
	for _,v := range prefix {
		if tire.next[v - 'a'] == nil {
			return res
		}else {
			tire = tire.next[v - 'a']
		}
	}

	var charsSince []byte
	for k,_ := range tire.next {
		if tire.next[k] != nil {
			var charSince []int
			charSince = append(charSince, k)
			getBranchChar(tire.next[k], &charSince)
			charsSince = []byte{}
			for _, v := range charSince {
				charsSince  = append(charsSince,chars[v])
			}
			res = append(res,prefix + string(charsSince))
		}
	}

	return res
}

func getBranchChar(root *Trie,charSince*[]int)  {
	if root == nil {
		return
	}

	for k,_ := range root.next {
		if root.next[k] != nil {
			*charSince = append(*charSince,k)
			getBranchChar(root.next[k],charSince);
		}
	}
}