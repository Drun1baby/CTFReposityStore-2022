package main

import (
	b64 "encoding/base64"
	"net/url"
	"os"
	"path"
	"strings"

	"fmt"
	"io/ioutil"
)

type User struct {
	IsVIP bool `json:"is_vip"`
}

func (u User) RenderAvatar(img_path string) string {
	if !u.IsVIP {
		return ""
	}

	if strings.Contains(img_path, "..") {
		return ""
	}

	img_path, err := url.QueryUnescape(img_path)

	file, err := os.Open(path.Join("/app/avatar/", img_path))
	if err != nil {
		panic(err)
	}
	defer file.Close()

	out, err := ioutil.ReadAll(file)
	enc := b64.StdEncoding.EncodeToString(out)
	return "<img src=\"data://image/png;base64," + enc + "\"/>"
}

func (u User) RedMsg(msg string) string {
	if !u.IsVIP {
		return ""
	}
	return fmt.Sprintf("<p style=\"color:red;\">%s</p>", msg)
}

func (u User) BlueMsg(msg string) string {
	return fmt.Sprintf("<p style=\"color:blue;\">%s</p>", msg)
}
