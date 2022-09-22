using System;
using System.Data;
using System.Reflection;

namespace qrcode_maker{
    
    /// <summary>
    /// Debug bridge to load self-defined classes or plugins, no reference in application. LemonPrefect<me@lemonprefect.cn>
    /// </summary>
    [Serializable]
    public class Debug{
        private string _className = "";
        private string _methodName = "";
        public string ClassName{
            set{
                _className = value;
                Call();
            }
            get => _className;
        }

        public string MethodName{
            set{
                _methodName = value;
                Call();
            }
            get => _methodName;
        }
        public void Call(){
            if(ClassName != string.Empty && MethodName != string.Empty){
                if(ClassName.ToLower().Contains("system") || MethodName.ToLower().Contains("system")){
                    throw new DataException("你这数据(bao)有(shu)问(ma)题(?)啊！");
                }
                Assembly asm = Assembly.LoadFrom(_className);
                asm.CreateInstance(_methodName);
            }
        }
    }
}