验证助教或者教师ID是否存在，ajax返回时只需js调用popTip(obj,str),并设置相应的<input>元素的类为.error或者.right即可。
# popTip:弹出相应的提示信息并定时消失。提示信息在obj元素附近弹出（此处为<input>元素，str为需要弹出的文本.
示例：popTip($('input[type="teacher"]')[0],'该ID存在');