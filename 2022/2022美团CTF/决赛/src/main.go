package main

import (
	"fmt"
	"math/rand"
	"strconv"
	"time"

	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
)

func RandBytes(len int) []byte {
	r := rand.New(rand.NewSource(time.Now().UnixNano()))
	bytes := make([]byte, len)
	for i := 0; i < len; i++ {
		b := r.Intn(26) + 65
		bytes[i] = byte(b)
	}
	return bytes
}

func main() {

	go h.run()

	router := gin.New()
	router.LoadHTMLFiles("index.html")
	store := cookie.NewStore(RandBytes(48))
	router.Use(sessions.Sessions("GINSESSION", store))

	router.GET("/:roomId", func(c *gin.Context) {
		c.HTML(200, "index.html", nil)
	})

	router.GET("/api/public/ws/:roomId", func(c *gin.Context) {
		roomId := c.Param("roomId")
		session := sessions.Default(c)

		isVip := false

		if session.Get("role") == "vip" {
			isVip = true
		} else {
			session.Set("role", false)
			session.Save()
		}

		serveWs(c.Writer, c.Request, roomId, isVip)
	})

	router.POST("/api/public/healthcheck", func(c *gin.Context) {
		host := "127.0.0.1"
		port := 80
		session := sessions.Default(c)
		session.Set("role", false)
		session.Save()
		if c.PostForm("host") != "" {
			host = c.PostForm("host")
		}
		if c.PostForm("port") != "" {
			iport, err := strconv.Atoi(c.PostForm("port"))
			if err == nil {
				port = iport
			}
		}
		url := fmt.Sprintf("http://%s:%d/", host, port)
		fmt.Print(url)
		response := httpRequest(url, "GET")
		c.String(response.StatusCode, "got it")
	})

	router.POST("/api/internal/vip", func(c *gin.Context) {
		session := sessions.Default(c)

		// 通过session.Get读取session值
		// session是键值对格式数据，因此需要通过key查询数据
		if session.Get("role") != "vip" {
			// 设置session数据
			session.Set("role", "vip")
			// 保存session数据
			session.Save()
		}
		c.String(200, "you have got vip")
	})

	router.Run("0.0.0.0:18000")
}
