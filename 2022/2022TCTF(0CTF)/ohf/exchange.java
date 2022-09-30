public static String encodeBase64File(String path) throws Exception {
        File file = new File(path);;
        FileInputStream inputFile = new FileInputStream(file);
        byte[] buffer = new byte[(int) file.length()];
        inputFile.read(buffer);
        inputFile.close();
        return new BASE64Encoder().encode(buffer);

        }

/**
 * 将base64字符解码保存文件
 * @param base64Code
 * @param targetPath
 * @throws Exception
 */

public static void decoderBase64File(String base64Code, String targetPath)
        throws Exception {
        byte[] buffer = new BASE64Decoder().decodeBuffer(base64Code);
        FileOutputStream out = new FileOutputStream(targetPath+"/1.wav");
        out.write(buffer);
        out.close();

        }
public static void main(String[] args) {
        try {
        String str= AudioPlayerUtils.encodeBase64File("D:/音频/2.mp3");
        String outUrl = ResourceUtils.getURL("classpath:static").getPath().replace("%20", " ").substring(1);
        AudioPlayerUtils.decoderBase64File(str,outUrl);
        }catch (Exception e){

        }