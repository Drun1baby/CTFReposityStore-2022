use std::env;
use serde::{Deserialize, Serialize};
use serde_json::Value;

static BLACK_PROPERTY: &str = "protocol";

#[derive(Debug, Serialize, Deserialize)]
struct File{
    #[serde(default = "default_protocol")]
    pub protocol: String,
    pub href: String,
    pub origin: String,
    pub pathname: String,
    pub hostname:String
}

pub fn default_protocol() -> String {
    "http".to_string()
}
//protocol is default value,can't be customized
pub fn waf(body: &str) -> String {
    if body.to_lowercase().contains("flag") ||  body.to_lowercase().contains("proc"){
        return String::from("./main.rs");
    }
    if let Ok(json_body) = serde_json::from_str::<Value>(body) {
        if let Some(json_body_obj) = json_body.as_object() {
            if json_body_obj.keys().any(|key| key == BLACK_PROPERTY) {
                return String::from("./main.rs");
            }
        }
        //not contains protocol,check if struct is File
        if let Ok(file) = serde_json::from_str::<File>(body) {
            return serde_json::to_string(&file).unwrap_or(String::from("./main.rs"));
        }
    } else{
        //body not json
        return String::from(body);
    }
    return String::from("./main.rs");
}

fn main() {
    let args: Vec<String> = env::args().collect();
    println!("{}", waf(&args[1]));
}