# go反射

## 目录

[TOC]



## 反射的基本介绍

### 变量的内在机制

Go语言中的变量是分为两部分的:

- 类型信息：预先定义好的元信息。
- 值信息：程序运行过程中可动态变化的。



### 反射介绍

​		反射是指在**程序运行期**对**程序本身**进行**访问**和**修改**的能力。程序在编译时，变量被转换为内存地址，变量名不会被编译器写入到可执行部很分。在运行程序时，程序无法获取自身的信息。

​		支持反射的语言可以在**程序编译期**将变量的反射信息，如字段名称、类型信息、结构体信息等整合到可执行文件中，并给程序提供接口访问反射信息，这样就可以在程序运行期获取类型的反射信息，并且有能力修改它们。

​		Go程序在运行期使用reflect包访问程序的反射信息。

​		在这之前我们介绍了空接口。 空接口可以存储任意类型的变量，那我们如何知道这个空接口保存的数据是什么呢？ 反射就是在运行时动态的获取一个变量的类型信息和值信息。



### reflect包

​		 在Go语言中反射的相关功能由内置的reflect包提供，任意接口值在反射中都可以理解为由`reflect.Type`和`reflect.Value`两部分组成，并且reflect包提供了`reflect.TypeOf`和`reflect.ValueOf`两个函数来获取任意对象的Value和Type。

### TypeOf

​		在Go语言中，使用`reflect.TypeOf()`函数可以获得任意值的类型对象（reflect.Type），程序通过类型对象可以访问任意值的类型信息。

```go
package main

import (
	"fmt"
	"reflect"
)

func reflectType(x interface{}) {
	v := reflect.TypeOf(x)
	fmt.Printf("type:%v\n", v)
}
func main() {
	var a float32 = 3.14
	reflectType(a) // type:float32
	var b int64 = 100
	reflectType(b) // type:int64
}
```

### type name和type kind

​		在反射中关于类型还划分为两种：`类型（Type）`和`种类（Kind）`。因为在Go语言中我们可以使用type关键字构造很多自定义类型，而`种类（Kind）`就是指底层的类型，但在反射中，当需要区分指针、结构体等大品种的类型时，就会用到`种类（Kind）`。 举个例子，我们定义了两个指针类型和两个结构体类型，通过反射查看它们的类型和种类。

```go
package main

import (
	"fmt"
	"reflect"
)

type myInt int64

func reflectType(x interface{}) {
	t := reflect.TypeOf(x)
	fmt.Printf("type:%v kind:%v\n", t.Name(), t.Kind())
}

func main() {
	var a *float32 // 指针
	var b myInt    // 自定义类型
	var c rune     // 类型别名
	reflectType(a) // type: kind:ptr
	reflectType(b) // type:myInt kind:int64
	reflectType(c) // type:int32 kind:int32

	type person struct {
		name string
		age  int
	}
	type book struct{ title string }
	var d = person{
		name: "沙河小王子",
		age:  18,
	}
	var e = book{title: "《跟小王子学Go语言》"}
	reflectType(d) // type:person kind:struct
	reflectType(e) // type:book kind:struct
}
```

### 通过反射获取值

```go
func reflectValue(x interface{}) {
	v := reflect.ValueOf(x)
	k := v.Kind()
	switch k {
	case reflect.Int64:
		// v.Int()从反射中获取整型的原始值，然后通过int64()强制类型转换
		fmt.Printf("type is int64, value is %d\n", int64(v.Int()))
	case reflect.Float32:
		// v.Float()从反射中获取浮点型的原始值，然后通过float32()强制类型转换
		fmt.Printf("type is float32, value is %f\n", float32(v.Float()))
	case reflect.Float64:
		// v.Float()从反射中获取浮点型的原始值，然后通过float64()强制类型转换
		fmt.Printf("type is float64, value is %f\n", float64(v.Float()))
	}
}
func main() {
	var a float32 = 3.14
	var b int64 = 100
	reflectValue(a) // type is float32, value is 3.140000
	reflectValue(b) // type is int64, value is 100
	// 将int类型的原始值转换为reflect.Value类型
	c := reflect.ValueOf(10)
	fmt.Printf("type c :%T\n", c) // type c :reflect.Value
}
```

### 通过反射设置变量的值

​		想要在函数中通过反射修改变量的值，需要注意函数参数传递的是值拷贝，必须传递变量地址才能修改变量值。而反射中使用专有的`Elem()`方法来获取指针对应的值。

```go
package main

import (
	"fmt"
	"reflect"
)

func reflectSetValue1(x interface{}) {
	v := reflect.ValueOf(x)
	if v.Kind() == reflect.Int64 {
		v.SetInt(200) //修改的是副本，reflect包会引发panic
	}
}
func reflectSetValue2(x interface{}) {
	v := reflect.ValueOf(x)
	// 反射中使用 Elem()方法获取指针对应的值
	if v.Elem().Kind() == reflect.Int64 {
		v.Elem().SetInt(200)
	}
}
func main() {
	var a int64 = 100
	// reflectSetValue1(a) //panic: reflect: reflect.Value.SetInt using unaddressable value
	reflectSetValue2(&a)
	fmt.Println(a)
}
```

### 类型的转换

   1）`reflect.TypeOf(变量名)`，获取变量的类型，返回`reflect.Type`类型
   2）`reflect.ValueOf(变量名)`，获取变量的值，返回`reflect.Type`类型的值，`reflect.Value`是一个结构体类型。【看文档】通过`reflect.Value`可以获取到关于变量的很多信息
   3）`变量`、`interface{}`和`reflect.Value`是可以相互转换的



```go
    
	var n1 int = 10
	var i1 interface{} = n1		// 基本类型 => interface{}

	refv := reflect.ValueOf(i1) // interface =>  reflect.Value
	fmt.Println(refv)

	i2 := refv.Interface()      // reflect.Value => interface{}
	n2 := i2.(int)              // interface{} => 基本类型
	fmt.Println(n2)


```



## 反射最佳案例

```go
package main

import (
	"fmt"
	"reflect"
)

type Monster struct {
	Name  string `json:"name"`
	Age   int    `json:"monster_age"`
	Score float32
	Sex   string
}

func (s Monster) Print() {
	fmt.Println("----start----")
	fmt.Println(s)
	fmt.Println("-----end-----")
}

func (s Monster) GetSum(n1, n2 int) int {
	return n1 + n2
}

func (s Monster) Set(name string, age int, score float32, sex string) {
	s.Name = name
	s.Age = age
	s.Score = score
	s.Sex = sex
}

func TestStruct(a interface{}) {
	typ := reflect.TypeOf(a)
	val := reflect.ValueOf(a)
	kd := val.Kind()
	if kd != reflect.Struct {
		fmt.Println("expect struct")
		return
	}
	num := val.NumField()
	fmt.Printf("struct has %d field\n", num)
	for i := 0; i < num; i++ {
		fmt.Printf("Field %d: 值为=%v\n", i, val.Field(i))
		tagVal := typ.Field(i).Tag.Get("json")
		if tagVal != "" {
			fmt.Printf("Field %d: tag为=%v\n", i, tagVal)
		}
	}
	numOfMethod := val.NumMethod()
	fmt.Printf("struct has %d method\n", numOfMethod)

	val.Method(1).Call(nil) // 结构体中的函数是通过函数的ASCII码排序的

	var params []reflect.Value
	params = append(params, reflect.ValueOf(10))
	params = append(params, reflect.ValueOf(40))
	res := val.Method(0).Call(params) // 传入切片返回切片，[]reflect.Value
	fmt.Println("res=", res[0].Int())
}

func main() {
	var a = Monster{
		Name:  "黄鼠狼精",
		Age:   400,
		Score: 30.8,
	}
	TestStruct(a)
}

```

## reflect.Value与interface{}

​		`reflect.value`和`interface{}`都可以包含任意类型的值。二者的区别是空接口（interface{}）隐藏了值的**布局信息**、**内置操作相关方法**，所以除非我们知到它的动态类型，并用一个**类型断言**来渗透进去，否则我们对所包含值能做的事情很少。

​		作为对比，value有很多方法可以用来分析所包含的值，而不用知道他的类型，因为value只关心**底层实现**。使用这种技术，我们可以尝试写一个格式化函数，而这个函数无需使用类型断言，其中用到是反射中的**reflect.Value**的**kind**方法来区分不同的类型。尽管有无限种类型（包括自定义类型-结构体），但类型的分类（kind）只有有限的几种（*官方文档*如下）：

```go
const (
    Invalid Kind = iota
    Bool
    Int
    Int8
    Int16
    Int32
    Int64
    Uint
    Uint8
    Uint16
    Uint32
    Uint64
    Uintptr
    Float32
    Float64
    Complex64
    Complex128
    Array
    Chan
    Func
    Interface
    Map
    Ptr
    Slice
    String
    Struct
    UnsafePointer
)
```

### 代码演示reflect.Value和kind的使用


```go
package main

import (
   "fmt"
   "reflect"
   "strconv"
)

// Any 把任何值格式化为一个字符串
func Any(value interface{}) string {
   return formatAtom(reflect.ValueOf(value))
}

// formatAtom 格式化一个值，且不分析它的内部结构
func formatAtom(v reflect.Value) string {
   switch v.Kind() {
   case reflect.Invalid:
      return "invalid"
   case reflect.Int,reflect.Int8,reflect.Int16,reflect.Int32,reflect.Int64:
      return strconv.FormatInt(v.Int(),10)
   case reflect.Uint,reflect.Uint8,reflect.Uint16,reflect.Uint32,reflect.Uint64,reflect.Uintptr:
      return strconv.FormatUint(v.Uint(),10)
   case reflect.Bool:
      return strconv.FormatBool(v.Bool())
   case reflect.String:
      return strconv.Quote(v.String())
   case reflect.Chan,reflect.Func,reflect.Ptr,reflect.Slice,reflect.Map:
      return v.Type().String()+" 0x" +strconv.FormatUint(uint64(v.Pointer()),16)
   default:
      return v.Type().String()+" value"
   }
}

func main() {
	var x int64 = 1
	var d time.Duration = 1 * time.Nanosecond
	fmt.Println(Any(x))
	fmt.Println(Any(d))
	fmt.Println(Any([]int64{x}))
	fmt.Println(Any([]time.Duration{d}))
}
```

## Didsplay：一个递归的值显示器

​		下面我们来实现一个调试工具函数，这个函数对给定的任意一个x变量，输出这个复杂值得完整结构，并对找到的元素标上这个元素的路径。代码说话：

```go
package main

import (
	"fmt"
	"reflect"
	"strconv"
)

type Movie struct {
	Title, Subtitle string
	Year            int
	Color           bool
	Actor           map[string]string
	Oscars          []string
	Sequel          *string
}

// formatAtom 格式化一个值，且不分析它的内部结构，用于输出基础数据类型
func formatAtom(v reflect.Value) string {
	switch v.Kind() {
	case reflect.Invalid:
		return "invalid"
	case reflect.Int, reflect.Int8, reflect.Int16, reflect.Int32, reflect.Int64:
		return strconv.FormatInt(v.Int(), 10)
	case reflect.Uint, reflect.Uint8, reflect.Uint16, reflect.Uint32, reflect.Uint64, reflect.Uintptr:
		return strconv.FormatUint(v.Uint(), 10)
	case reflect.Bool:
		return strconv.FormatBool(v.Bool())
	case reflect.String:
		return strconv.Quote(v.String())
	case reflect.Chan, reflect.Func, reflect.Ptr, reflect.Slice, reflect.Map:
		return v.Type().String() + " 0x" + strconv.FormatUint(uint64(v.Pointer()), 16)
	default:
		return v.Type().String() + " value"
	}
}

// display用于递归展开复杂数据类型的每个组成部分
func display(path string, v reflect.Value) {
	switch v.Kind() {
	case reflect.Invalid:
		fmt.Printf("%s = invalid\n", path)
	case reflect.Slice, reflect.Array:
		for i := 0; i < v.Len(); i++ {
			display(fmt.Sprintf("%s[%d]", path, i), v.Index(i))
		}
	case reflect.Struct:
		for i := 0; i < v.NumField(); i++ {
			fieldPath := fmt.Sprintf("%s.%s", path, v.Type().Field(i).Name)
			display(fieldPath, v.Field(i))
		}
	case reflect.Map:
		for _, key := range v.MapKeys() {
			display(fmt.Sprintf("%s[%s]", path, formatAtom(key)), v.MapIndex(key))
		}
	case reflect.Ptr:
		if v.IsNil() {
			fmt.Printf("%s = nil\n", path)
		} else {
			display(fmt.Sprintf("(*%s)", path), v.Elem())
		}
	case reflect.Interface:
		if v.IsNil() {
			fmt.Printf("%s = nil\n", path)
		} else {
			fmt.Printf("%s.type = %s\n", path, v.Elem().Type())
			display(path+".value", v.Elem())
		}
	default:
		fmt.Printf("%s = %s\n", path, formatAtom(v))
	}
}

func Display(name string, x interface{}) {
	fmt.Printf("Display %s (%T):\n", name, x)
	display(name, reflect.ValueOf(x))
}

func main() {
	stranglelove := Movie {
		Title:"Dr.Stranglelove",
		Subtitle:"How I Learned to Stop Worrying and Love the Bomb",
		Year:1964,
		Color:false,
		Actor: map[string]string{
			"Dr.Stranglelove":"Peter Sellers",
			"Grp.Capt.lionel Mandrake":"Peter Sellers",
			"Pres.Markin Muffley":"Peter Sellers",
			"Gen.Buck Turgidson":"George C.Scott",
			"Brig.Gen.Jack D.Ripper":"Sterling Hayden",
			`Maj.T.J. "King" Kong`:"Slim Pickens",
		},
		Oscars:[]string{
			"Best Actor (Momin.)",
			"Best Adapted Screenplay (Momin.)",
			"Best Director (Momin.)",
			"Best Picture (Momin.)",
		},
	}
	Display("strangelove",stranglelove)
}

```



## 反射的注意事项和使用说明

1. reflect.Value.kind，获取变量的类别，返回的是一个常量【看手册】

2. Type是类型、kind是类别，Type和kind的可能是相同，也可能不同

   比如：var num int = 10 	num的Type和kind都是int（基本数据类型）

   ​			 var stu Student		stu的Type是**包名.Student**，kind是**struct**

3. 通过反射可以让变量在interface{}和reflect.Value之间相互转换

4. 使用反射的方式来获取变量的值（返回变量对应的类型），要求数据类型匹配，比如x是int，那么就应该使用reflect.Value(x).int()，而不是使用其它，否则会报panic

5. 通过反射来修改变量，注意当使用SetXxx()方法来设置变量的值，需要通过对应的指针类型来完成，这样才能改变传入的变量的值，同时要使用到reflect.Value.Elem()方法

   ```go
   package main
   import "fmt"
   func main() {
       var num int = 10
       fmt.Println(num)
       inter := interface{}
       inter = &num
       rVal := reflect.ValueOf(inter)
       rVal.Elem().SetInt(100)
       fmt.Println(num)
   }
   ```

   

   

