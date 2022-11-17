#!/bin/sh
#LANG=C
#LANG=ko.UTF-8
#export LANG
mkdir $HOSTNAME

######################################################################
############################### 기본 설정 ############################
######################################################################
PASSWD="/etc/passwd"        #### 패스워드 파일 위치 ####
SHADOW="/etc/shadow"        #### 쉐도우 파일 위치 ####
GROUP="/etc/group"        #### group 파일 위치 ####
PASSWD_CONF_1="/etc/login.defs"       #### 패스워드 정책 파일 위치 ####
PASSWD_CONF_2="/etc/pam.d/system-auth"      #### 패스워드 정책 파일 위치 ####
HOSTS_EQUIV="/etc/hosts.equiv"       #### hosts.equiv 파일 위치 ####
LOGIN_CONF="/etc/pam.d/login"       #### 로그인 설정 파일 위치 ####
INETD_CONF="/etc/inetd.conf"       #### inetd.conf 파일 위치 ####
XINETD_CONF="/etc/xinetd.conf"       #### inetd.conf 파일 위치 ####
HOSTS="/etc/hosts"        #### hosts 파일 위치 ####
CRON_ALLOW="/etc/cron.allow"       #### cron.allow 파일 위치 ####
CRON_DENY="/etc/cron.deny"       #### cron.deny 파일 위치 ####
AT_ALLOW="/etc/at.allow"        #### at.allow 파일 위치 ####
AT_DENY="/etc/at.deny"        #### at.deny 파일 위치 ####
TELNET_BANNER="/etc/issue"       #### 텔넷 로그인 배너 설정 파일 ####
FTP_BANNER="/etc/banners/ftp.msg"       #### FTP 로그인 배너 설정 파일 ####
SYSLOG_CONF="/etc/syslog.conf"       #### SYSLOG 설정 파일 ####
SERVICES="/etc/services"        #### services 파일 위치 ####
SNMP_CONF="/etc/snmp/snmpd.conf"      #### snmpd 설정 파일 위치 ####
SMTP_CONF="/etc/mail/sendmail.cf"       #### 센드메일 설정 파일 ####
SMTP_SPAM="/etc/mail/access"       #### 스팸 릴레이 설정 파일 ####
SSH_CONFIG="/etc/ssh/sshd_config"       #### SSH 로그인 환경 설정 파일 ####
NAMED_CONF="/etc/named.conf"       #### DNS 환경설정 파일 ####
SERVICE="ypserv|ypbind|ypxfrd|rpc.yppasswdd|rpc.ypupdated" #### NIS, NIS+ 점검 파일 ####
######################################################################

chmod 600 $HOSTNAME/$HOSTNAME.txt

echo "**************************************************************************"
echo "*																		   *"
echo "*		          Team. ShineMusket LINUX CheckList V1.01				   *"
echo "*																		   *"
echo "**************************************************************************"
echo " "
echo " "

echo " ** Start Time "
date
echo " "
echo "======================= System Information Query Start ========================"
echo " "

echo "### 네트워크 현황 ###"
echo " "
ifconfig -a
echo " "

echo "### 프로세스 현황 ###"
echo " "
ps -ef | grep -v grep | grep -v ps | sort | uniq
echo " "

echo "### 열려 있는 포트 리스트 ###"
echo " "
netstat -an | grep -i listen
echo " "

echo "======================= System Information Query End ========================"

echo "========================== 진단 시작 ========================="
echo " "

echo "******************************** 1. 계정 관리 ******************************"
echo " "

echo "-------------------- U-01. root 계정 원격 접속 제한 -----------------------"
echo "[_START_]"
echo "[기준]: 원격 터미널 서비스를 사용하지 않거나, 사용 시 root 직접 접속을 차단한 경우 양호"
echo "[현황]"
echo " "

echo "## sh 진단"
cat $SSH_CONFIG | grep "PermitRootLogin"
echo " "

echo "## /etc/pam.d/login 진단"
grep -i "^auth" $LOGIN_CONF 
echo " "

echo "## /etc/securetty 진단"
cat /etc/securetty | grep "pts"
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo " "
echo "SSH - PermitRootLogin no로 설정되어 있으면 양호"
echo " "
echo "/etc/securetty 파일에 pts/0~9가 설정되어 있으면 주석 처리 또는 삭제"
echo " "
echo "/etc/pam.d/login파일에 'auth required /lib/security/pam_securetty.so' 설정"
echo " "

echo "[_REND_]"
echo " "

echo "-------------------- U-02. 패스워드 복잡도 설정 ---------------------------"
echo "[_START_]"
echo "[기준]: 영문, 숫자, 특수문자 조합하여 2종류 조합시 10자리, 3종류 이상 조합시 8자리로 패스워드 설정 시 양호 (공공기관 9자리 이상)"
echo "[현황]"
echo " "

echo "## cat /etc/pam.d/system-auth | grep password 점검"
cat $PASSWD_CONF_2 | grep "password"
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo "HOSTNAME.etc.pam.d.system-auth.txt 파일을 참고하여 패스워드를 영문, 숫자 혼합 사용하여 복잡하게 설정되어 있는지 확인"
echo "password requisite /lib/security/pam_cracklib.so 설정이 되어 있다면 양호"
echo " "

echo "retry=3 minlen=8 lcredit=-1 ucredit=-1 dcredit=-1 ocredit=-1"
echo "retry   : 패스워드 입력 실패 시 재시도 횟수"
echo "minlen  : 최소 패스워드 길이 설정"
echo "lcredit : 최소 소문자 요구"
echo "ucredit : 최소 대문자 요구"
echo "dcredit : 최소 숫자 요구"
echo "ocredit : 최소 특수문자 요구"
echo " "

echo "[_REND_]"
echo " "

echo "-------------------- U-03. 계정잠금 임계값을 설정 -------------------------"
echo "[_START_]"
echo "[기준]: 계정 잠금 임계값이 5 이하인 경우 양호"
echo "[현황]"
echo " "

echo "## cat /etc/pam.d/system-auth | grep deny 점검"
cat $PASSWD_CONF_2 | grep "deny="
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "

echo "HOSTNAME.etc.pam.d.system-auth.txt 파일을 참고하여 아래와 같이 설정되어 있는지 확인"
echo "auth required /lib/security/pam_tally.so deny=5 lock_time=120 no_magic_root reset 설정이 되어있다면 양호"
echo " "

echo "deny=5 5회 실패시 계정 잠금"
echo "lock_time=120 120초간 계정 잠금"
echo " "

echo "[_REND_]"
echo " "

echo "-------------------- U-04. 패스워드 파일 보호 -----------------------------"
echo "[_START_]"
echo "[기준]: 쉐도우 패스워드 사용하거나, 패스워드 암호화 저장한 경우 양호"
echo "[현황]"
echo " "

echo "/etc/passwd 파일 확인"
cat $PASSWD
echo " "

echo "/etc/shadow 파일 확인"
cat $SHADOW
echo " "

echo "cat /etc/passwd | grep root 점검"
cat $PASSWD | grep "root"
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "

echo "패스워드 혹은 쉐도우 파일 내 패스워드가 암호화되어 저장되어 있을 경우 C2 Level 적용 완료"
echo " "

echo "[_REND_]"
echo " "

echo "-------------------- U-44. root이외의 UID가 '0'금지 ----------------------"
echo "[_START_]"
echo "[기준]: root 계정과 동일한 UID를 갖는 계정이 존재하지 않을 경우 양호"
echo "[현황]"
echo " "

echo "1. UID가 0인 사용자"
awk -F: '($3 == "0") {print $1}' $PASSWD
echo " "

echo "2. GID가 0인 사용자"
awk -F: '($4 == "0") {print $1}' $PASSWD
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "

echo "관례적으로 100보다 작은 UID들과 10보다 작은 GID들은 시스템 계정을 위해 사용됨"
echo " "

echo "[_REND_]"
echo " "

echo "-------------------- U-45. root계정 su제한 -------------------------------"
echo "[_START_]"
echo "[기준]: su 명령어를 특정 그룹에 속한 사용자만 사용토록 제한되어 있는 경우 양호"
echo "[현황]"

echo "1. wheel 그룹(su 명령어 사용 그룹) 및 그룹 내 구성원 존재여부 확인 (etc/group)"
cat $GROUP | grep -i "wheel"
echo " "

echo "2. wheel 그룹이 su 명령어를 사용할 수 있는지 설정 여부 확인 및 파일 권한 확인 (/usr/bin/su or /bin/su)"
ls -l /usr/bin/su
echo " "
ls -l /bin/su
echo " "

echo "## LINUX PAM 모듈 이용 시"
echo "3. 허용 그룹(su 명령어 사용 그룹) 설정 여부 확인 (cat /etc/pam.d/su | grep pam.wheel.so)"
cat /etc/pam.d/su | grep pam.wheel.so
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "

echo "@ 권고 사항"
echo "1~2. 권한 있는 사용자만 su 명령어를 사용하도록 권한 변경 (그룹으로 관리)"
echo "권한은 4750(-rwsr-x---) 권고, 4555(-r-s-r-x-r-x) 취약"
echo "3. LINUX PAM 모듈 이용 시 /etc/pam.d/su 내에 아래와 같이 주석제거(wheel 그룹 활성화)"
echo "auth required /lib/security/pam_wheel.so debug group=wheel"
echo "auth required /lib/security//pam_wheel.so use_id"
echo " "
echo " "

echo "[_REND_]"
echo " "
echo " "

echo "-------------------- U-46. 패스워드 최소 길이 설정 ------------------------"
echo "[_START_]"
echo "[기준]: 패스워드 최소 길이가 9자 이상 설정시 양호(공공기관은 9자리 이상)"
echo "[현황]"
echo " "

echo "## /etc/login.defs | grep -i PASS_MIN_LEN 점검"
cat $PASSWD_CONF_1 | grep -i "PASS_MIN_LEN"
echo " "

echo "## /etc/login.defs | grep PASS_MIN_LEN 점검"
cat $PASSWD_CONF_1 | grep "PASS_MIN_LEN"
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "생성된 HOSTNAME.PASSWD.CONF.txt 파일 참고"
echo "default 값 및 각 계정의 minlen 값이 8로 설정되어 있는지 확인"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-47. 패스워드 최대 사용 기간 설정 -------------------"
echo "[_START_]"
echo "[기준]: 패스워드 최대 사용기간 90일(12주) 이하로 설정되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## /etc/login.defs | grep -i PASS_MAX_DAYS 점검"
cat $PASSWD_CONF_1 | grep -i "PASS_MAX_DAYS"
echo " "

echo "## /etc/login.defs | grep PASS_MAX_DAYS 점검"
cat $PASSWD_CONF_1 | grep "PASS_MAX_DAYS"
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "최대 사용 기간을 설정할 경우 root로 su를 못할 수 있으므로 root의 경우 아래와 같이 설정하여 패스워드가 만료되지 않도록 함."
echo "* passwd -x -1 root"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-48. 패스워드 최소 사용기간 설정 ---------------------"
echo "[_START_]"
echo "[기준]: 패스워드 최소 사용기간이 설정되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## /etc/login.defs | grep -i PASS_MIN_DAYS 점검"
cat $PASSWD_CONF_1 | grep -i "PASS_MIN_DAYS"
echo " "

echo "## /etc/login.defs | grep PASS_MIN_DAYS 점검"
cat $PASSWD_CONF_1 | grep "PASS_MIN_DAYS"
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "최소 사용 기간을 설정할 경우 root로 su를 못할 수 있으므로 root의 경우 아래와 같이 설정하여 패스워드가 만료되지 않도록 함."
echo "* passwd -x -1 root"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-49. 불필요한 계정 제거 -----------------------------"
echo "[_START_]"
echo "[기준]: 불필요한 계정이 존재하지 않을 시 양호"
echo "[현황]"
echo " "

echo "## 사용하지 않는 default 계정 점검"
cat $PASSWD
echo " "
echo " "
echo "## 90일 동안 로그인 하지 않은 계정 점검"
lastlog -b 90
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "/etc/passwd의 계정 설명은 가이드라인 부록 참조"
echo "UID 100이하 또는 60000 이상의 계정들은 시스템 계정으로 로그인 불필요"
echo " "
echo "생성된 HOSTNAME.PASSWD.txt를 통해 계정 확인"
echo "담당자와의 인터뷰를 통해 불필요한 계정 확인 필요"
echo " "
echo "/bin/false"
echo "-> 시스템의 로그인은 불가능, FTP 서버 프로그램 같은 프로그램도 불가능하다."
echo "쉘이나 SSH과 같은 터널링(원격접속) 그리고 홈디렉터리 사용 불가."
echo " "
echo "/sbin/nologin"
echo "-> 사용자 계정의 쉘부분에 /bin/nologin 으로 설정을 하면 로그인 불가, 메시지들은 반환됨."
echo "SSH는 사용불가능하며, FTP의 경우 사용가능함."
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-50. 관리자 그룹에 최소한의 계정 포함 ----------------"
echo "[_START_]"
echo "[기준]: 관리자 그룹에 불필요 계정이 등록되어 있지 않을 시 양호"
echo "[현황]"
echo " "

echo "## /etc/group 내에 root 계정 점검"
cat $GROUP | grep "root"
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "관리자 그룹에 최소한의 계정 포함에 대해 담당자 인터뷰 확인"
echo "## 예시"
echo "system:!:0:root,test"
echo "system:!:0:root (test 삭제)"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-51. 계정이 존재하지 않는 GID금지 -------------------"
echo "[_START_]"
echo "[기준]: 시스템 관리나 운용에 불필요한 그룹이 삭제되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## /etc/group 점검, root가 포함된 그룹에 속한 사용자 확인"
cat $GROUP
echo " "

echo "## /etc/group 2개 이상의 계정 점검"
cat $GROUP | ## 명령어 찾아라!
echo " "

echo "## /etc/passwd 참조"
cat $PASSWD
echo " "

echo "## /etc/gshadow 참조"
cat /etc/gshadow
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "/etc/group과 [HOSTNAME].PASSWD의 GID가 상이한지 비교"
echo "같다면 양호 상이하다면 취약"
echo " "

echo "/etc/group에서 그룹에 지정하지 않아도 GID 값이 존재하면 해당 그룹 소속 계정이므로"
echo "/etc/passwd의 계정에 대한 GID 값도 같이 확인 필요. 담당자와 인터뷰를 통해 검토 필요"
echo " "

echo "/etc/group 파일구성= 계정명(ID):패스워드:UID:GID:계정설명:홈 디렉터리:shell정보"
echo "/etc/gshadow파일구성= 그룹명:패스워드:관리자:멤버"
echo " "

echo "/etc/gshadow파일: shadow파일에 사용자 계정의 암호가 저장되어 있는것 처럼"
echo "시스템 내 존재하는 그룹의 암호 정보 저장 파일로 그룹 관리자 및 구성원 설정 가능"
echo " "
echo "[_REND_]"

echo "-------------------- U-52. 동일한 UID 금지 -------------------------------"
echo "[_START_]"
echo "[기준]: 동일한 UID로 설정된 사용자 계정이 존재하지 않을 시 양호"
echo "[현황]"
echo " "

echo "## 계정이 존재하지 않는 UID 확인"
echo "UID 사용자"
awk -F: '($3 == "*"){print $1}' $PASSWD
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "UID가 동일한 계정에 대해 담당자 인터뷰 필요 후 진단"
echo "결과 값이 없다면 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-53. 사용자 shell 점검 -----------------------------"
echo "[_START_]"
echo "[기준]: 로그인이 불필요한 계정에 /bin/false(/sbin/nologin) 쉘이 부여되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## /etc/passwd 내 /sbin/nologin 점검"
cat $PASSWD | awk -F: '{print $1, $7}'
echo " "

echo "## /etc/passwd 내 불필요한 계정 유무 확인"
cat /etc/passwd | egrep "^daemon|^bin|^sys|^adm|^listen|^nobody|^nobody4|^noacess|^diag|^operator|^games|^gopher" | grep -v "admin" 
echo " "
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "일반적으로 로그인이 불필요한 계정"
echo "daemon, bin, sys, adm, listen, nobody, nobody4, noacess, diag, operator, games, gopher"
echo " "
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-54. Session Timeout설정 --------------------------"
echo "[_START_]"
echo "[기준]: Session Timeout이 600초(10분) 이하 설정시 양호"
echo "[현황]"
echo " "

echo "## <sh, ksh, bash>"
echo "## /etc/profile 점검 (TMOUT 유무 확인)"
cat /etc/profile | grep "TMOUT"
echo " "

echo "## <csh>"
echo "## /etc/csh.login 점검 (autologout 유무 확인)"
cat /etc/csh.login | grep -i "autologout"
echo " "

echo "## /etc/csh.cshrc 점검 (autologout 유무 확인)"
cat /etc/csh.cshrc | grep -i "autologout"
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "/etc/profile에 'TMOUT=600 (단위 : 초)', 'export TMOUT' 설정"
echo " "
echo "/etc/csh.login or /etc/csh.cshrc 에서 'set autologout=10 (단위 : 분)' 확인"
echo " "
echo "[_REND_]"
echo " "

echo "************************* 2. 파일 및 디렉터리 관리 *************************"
echo " "

echo "-------------- U-05. root 홈, 패스 디렉터리 권한 및 PATH 설정 -------------"
echo "[_START_]"
echo "[기준]: PATH 환경변수에 .이 맨 앞이나 중간에 포함되지 않을시 양호"
echo "[현황]"
echo " "

echo "## root 홈 권한 확인(권한 및 갯수 확인), (dr-------- under 700)"
ls -aldL $HOME
echo " "

echo "## <born, ksh>"
cat /etc/profile | grep -i "path"
cat $HOME/.profile | grep -i "path"
echo " "

echo "## <C Shell>"
cat /etc/.login | grep -i "path"
cat $HOME/.cshrc | grep -i "path"
echo " "

echo "<Bash>"
cat $HOME/.bash_profile | grep -i "path"
echo " "

echo "env 확인"
env | grep -i "path"
echo " "

echo "## echo PATH 점검"
echo $PATH
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo " root 계정의 PATH 환경 변수에 '.'이 포함되어 있는지 확인 (제거)"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-06. 파일 및 디렉터리 소유자 설정 -------------------"
echo "[_START_]"
echo "[기준]: 소유자가 존재하지 않는 파일 및 디렉터리가 존재하지 않을 시 양호"
echo "[현황]"
echo " "

echo "## 소유자가 존재하지 않는 파일 및 디렉터리 점검"
find / \(-nouser -o -nogroup \) -ls 2> /dev/null
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "해당 명령어들은 서버의 과부하를 줄 가능성이 있으므로 고객사와 협의 하여 스크립트 실행."
echo "인터뷰 대체 또는 위험 가능성 있는 디렉터리만 선택하여 스크립트 수행 권고."
echo " "
echo "[_REND_]"
echo " "

echo "---------------- U-07. /etc/passwd 파일 소유자 및 권한 설정 ---------------"
echo "[_START_]"
echo "[기준]: /etc/passwd 파일의 소유자가 root 이고, 권한이 644 이하일시 양호"
echo "[현황]"
echo " "

echo "## /etc/passwd 점검"
ls -aldL $PASSWD
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "소유자 root, -rw-r--r-- under 644"
echo " "
echo "[_REND_]"
echo " "

echo "---------------- U-08. /etc/shadow 파일 소유자 및 권한 설정 ---------------"
echo "[_START_]"
echo "[기준]: /etc/shadow 파일의 소유자가 root 이고, 권한이 400 이하일시 양호"
echo "[현황]"
echo " "

echo "## /etc/shadow 점검"
ls -aldL $SHADOW
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "소유자 root, -r-------- under 400"
echo " "
echo "[_REND_]"
echo " "

echo "---------------- U-09. /etc/hosts 파일 소유자 및 권한 설정 ----------------"
echo "[_START_]"
echo "[기준]: /etc/hosts 파일의 소유자가 root 이고, 권한이 600 이하일시 양호"
echo "[현황]"
echo " "

echo "## /etc/hosts 점검"
ls -aldL $HOSTS
ls -aldL /etc/inet/hosts
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "소유자 root, -rw------- under 600"
echo " "
echo "[_REND_]"
echo " "

echo "------------ U-10. /etc/(x)inetd.conf 파일 소유자 및 권한 설정 ------------"
echo "[_START_]"
echo "[기준]: /etc/(x)inetd.conf 파일의 소유자가 root 이고, 권한이 600 이하일시 양호"
echo "[현황]"
echo " "

echo "## /etc/inetd.conf 점검"
ls -aldL $INETD_CONF
echo " "
echo "## /etc/xinetd.conf 점검"
ls -aldL $XINETD_CONF
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "소유자 root, -rw------- under 600"
echo " "
echo "[_REND_]"
echo " "

echo "-------------- U-11. /etc/syslog.conf 파일 소유자 및 권한 설정 --------------"
echo "[_START_]"
echo "[기준]: /etc/syslog.conf 파일의 소유자가 root(또는 bin, sys) 이고, 권한이 640 이하일시 양호"
echo "[현황]"
echo " "

echo "CentOS 6 이상일 경우 /etc/rsyslog.conf 파일 소유자 및 권한 확인"
echo "## /etc/syslog.conf 점검"
if [-e /etc/syslog.conf]; then
	ls -aldL $SYSLOG_CONF
fi

if [-e /etc/rsyslog.conf]; then
	ls -aldL /etc/rsyslog.conf
fi
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "소유자 root, -rw-r----- under 640"
echo " "
echo "[_REND_]"
echo " "

echo "--------------- U-12. /etc/services 파일 소유자 및 권한 설정 --------------"
echo "[_START_]"
echo "[기준]: /etc/services 파일의 소유자가 root(또는 bin, sys) 이고, 권한이 644 이하일시 양호"
echo "[현황]"
echo " "

echo "## /etc/services 점검"
ls -aldL $SERVICES
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "소유자 root, -rw-r--r-- under 644"
echo " "
echo "[_REND_]"
echo " "

echo "--------------- U-13. SUID, SGID, Sticky bit 설정 파일 점검 --------------"
echo "[_START_]"
echo "[기준]: 주요 실행파일의 권한에 SUID와 SGID에 대한 설정이 부여되어 있지 않을 시 양호"
echo "[현황]"
echo " "

echo "## SUID/SGID의 설정이 적절한가?"
find / -xdev -user root -type f -perm -4000 -o -perm -2000 -exec ls -al '{}' \; 
## 밑 부분 확인 필요
find /sbin/dump \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /sbin/restore \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /sbin/unix_chkpwd \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lpq-lpd \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/newgrp \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lpr \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lpq-lpd \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/at \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lprm \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lpq \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lprm-lpd \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lpc-lpd \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /usr/bin/lpc \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
find /bin/traceroute \(-perm -04000 -o -perm -02000 \) -exec ls -al '{}' \;
echo " "

echo "## tmp 디렉토리의 권한을 Sticky bit로 설정하였는가?"
ls -ld /tmp /var/tmp
echo " "
echo "## 위 내용에서 /tmp, /var/tmp 디렉토리의 권한이 1777(drwxrwxrwx)임을 확인."
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "아래 14개 항목은 SUID/SGID 제거 권고"
echo "1. /sbin/dump, 2. /sbin/restore : 백업"
echo "3. /sbin/unix_chkpwd : 사용자의 암호검사 프로그램"
echo "4. /usr/bin/at : 지정된 시간에 실행할 작업을 입력, 대기목록 확인, 제거"
echo "5. /usr/bin/lpq : 프린터 작업 큐 조회 명령어"
echo "6. /usr/bin/lpr : 콘솔환결에서 명시된 파일을 인쇄"
echo "7. /usr/bin/lprm : lpd명령어로 볼 수 있는 작업 큐 살펴보기, 취소, 삭제"
echo "8. /usr/bin/newgrp 현재 세션의 사용자 그룹 변경(지정한 그룹의 쉘로 환경이 바로 변경)"
echo "9. /usr/sbin/lpc 커맨드 기반의 프린트 제어"
echo "10. /bin/traceroute 네트워크 경로 출력"
echo "11. /usr/bin/lpq-lpd, 12. /usr/bin/lpr-lpd, 13. /usr/bin/lprm-lpd ,14. /usr/sbin/lpc-lpd: 데몬"
echo " "
echo "[_REND_]"
echo " "

echo "---------- U-14. 사용자, 시스템 시작파일 및 환경파일 소유자 및 권한 설정 ----------"
echo "[_START_]"
echo "[기준]: 홈 디렉터리 환경변수 파일 소유자가 root 또는 해당 계정으로 지정되어 있고, 홈 디렉터리 환경변수 파일에 root와 소유자만 쓰기 권한 부여되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## 환경파일의 소유자 및 권한 설정 점검"
ls -al /etc/profile $HOME/.bash_profile $HOME/.bashrc $HOME/.cshrc $HOME/.bash_history
echo " "

echo "## 부팅 스크립트의 권한 설정 점검"
ls -alR /etc/rc*
ls -alR /etc/init*
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "환경 설정 파일의 접근권한을 under 644(-rw-r--r--)으로 설정함"
echo " "
echo "[_REND_]"
echo " "

echo "--------------------- U-15. world writable 파일 점검 ---------------------"
echo "[_START_]"
echo "[기준]: World writable 파일이 존재하지 않거나, 존재 시 설정 이유를 확인하고 있는 경우 양호"
echo "[현황]"
echo " "

echo "## World writable 파일 확인"
find /usr -type f -perm -2 -ls
find /etc -type f -perm -2 -ls
find /dev -type f -perm -2 -ls
find /var -type f -perm -2 -ls
find /tmp -type f -perm -2 -ls
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "점검 시 시스템 부하가 걸리므로 담당자와 협의 후 점검 여부 결정"
echo "파일이 존재하지 않으면 양호, 존재한다면 불필요한 World writable 권한 삭제"
echo " "
echo "[_REND_]"
echo " "

echo "--------------- U-16. /dev에 존재하지 않는 device 파일 점검 ---------------"
echo "[_START_]"
echo "[기준]: dev에 대한 파일 점검 후 존재하지 않은 device 파일을 제거한 경우 양호"
echo "[현황]"
echo " "

echo "## /dev의 device 파일 확인"
find /dev -type f -exec ls -l '{}' \;
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "파일이 존재하지 않으면 양호, 존재한다면 불필요한 device 파일 삭제"
echo " "
echo "[_REND_]"
echo " "

echo "--------------- U-17. /root/.rhosts, hosts.equiv 사용 금지 ---------------"
echo "[_START_]"
echo "[기준]: login, shell, exec 서비스를 사용하지 않거나, 사용 시 아래와 같은 설정이 적용된 경우"
echo "1. /etc/hosts.equiv 및 /root/.rhosts 파일 소유자가 root 또는 해당 계정인 경우"
echo "2. /etc/hosts.equiv 및 /root/.rhosts 파일 권한이 600 이하인 경우"
echo "3. /etc/hosts.equiv 및 /root/.rhosts 파일 설정이 '+' 설정이 없는 경우"
echo "위 사항 만족 시 양호"
echo " "
echo "[현황]"
echo " "

echo "## /root/.rhosts, hosts.equiv 을 사용하고 있는가?"
ps -ef | egrep "rlogin|rcp|rcmd|rexec" | grep -v "grep"
echo " "

echo "## hosts.equiv 파일 점검"
cat $HOSTS_EQUIV
echo " "

echo "## HOME/.rhosts 점검"
cat $HOME/.rhosts
echo " "

echo "## hosts.equiv & .rhosts 권한 점검"
ls -al $HOSTS_EQUIV
ls -al $HOME/.rhosts
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "(/etc/hosts.equiv 및 HOME/.rhosts 파일 삭제)"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-18. 접속 ip 및 포트 제한 --------------------------" 
echo "[_START_]"
echo "[기준]: 접속을 허용할 특정 호스트에 대한 IP 주소 및 포트 제한을 설정한 경우 양호"
echo "[현황]"
echo " "

echo "## TCP Wrapper 사용할 경우"
echo "## All deny 적용 확인 및 접근 허용 IP 적절성 확인"
echo "## /etc/hosts.deny, /etc/hosts.allow 확인"
cat /etc/hosts.deny
cat /etc/hosts.allow
echo " "

echo "## IPtables 사용할 경우"
echo "## iptables -L 확인"
iptables -L
echo " "

echo "## CentOS 7 이상일 경우 iptables 대신 firewalld를 default로 사용"
echo "## 전체 존 상세 출력 firewall-cmd --list-all-zones 확인"
firewall-cmd --list-all-zones
echo " "

echo "## default로 설정된 존 출력 firewall-cmd --get-default-zone 확인"
firewall-cmd --get-default-zone
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "## host.deny = all:all, /etc/hosts.allow = 허용할 IP대역 및 IP 기재 (접근제어 설정파일)"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-55. hosts.lpd파일 소유자 및 권한설정 ---------------"
echo "[_START_]"
echo "[기준]: hosts.lpd 파일이 삭제되어 있거나 불가피하게 hosts.lpd 파일을 사용할 시 파일의 소유자가 root이고 권한이 600일시 양호"
echo "[현황]"
echo " "

echo "/etc/hosts.lpd 점검 (소유자 root, -rw------- under 600)"
ls -aldL /etc/hosts.lpd
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-56. UMASK 설정 관리 -------------------------------"
echo "[_START_]"
echo "[기준]: UMASK 값이 022 이상으로 설정되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## /etc/profile 내의 UMASK 값 확인"
cat /etc/profile | grep -i "UMASK"
echo " "

echo "## UMASK 명령확인"
umask
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "/etc/profile UMASK 값 022로 설정"
echo "UMASK 값 0022로 설정"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-57. 홈 디렉터리 소유자 및 권한 설정 -----------------"
echo "[_START_]"
echo "[기준]: 홈 디렉터리 소유자가 해당 계정이고, 타 사용자 쓰기 권한이 제거되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## /etc/passwd 파일 확인"
cat $PASSWD
echo " "

echo "## 홈 디렉터리 확인"
ls -l /home
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "소유자가 디렉터리 소유자로 되어있고 권한이 under 711(drwx--x--x)으로 되어 있을시 양호"
echo "홈 디렉터리 소유자가 HOSTNAME.PASSWD.txt에 등록된 사용자와 일치하도록 변경"
echo " "
echo "[_REND_]"
echo " "

echo "-------------- U-58. 홈 디렉터리로 지정한 디렉터리의 존재 관리 -------------"
echo "[_START_]"
echo "[기준]: 홈 디렉터리가 존재하지 않는 계정이 발견되지 않을 시 양호"
echo "[현황]"
echo " "

cat $PASSWD | awk -F: '{print $1, $6}'
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "불법적이거나 의심스러운 디렉터리가 있어서 삭제한 경우 양호"
echo " "
echo "[_REND_]"
echo " "

echo "---------------- U-59. 숨겨진 파일 및 디렉터리 검색 및 제거 ----------------"
echo "[_START_]"
echo "[기준]: 불필요하거나 의심스러운 숨겨진 파일 및 디렉터리를 삭제한 경우 양호"
echo "[현황]"
echo " "

echo "## 숨겨진 파일 및 디렉터리 점검"
find / -name '.*'
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "'.'이 붙은 것은 숨김 파일"
echo " "
echo "[_REND_]"
echo " "

echo "****************************** 3. 서비스 관리 ******************************"
echo " "

echo "-------------------- U-19. Finger 서비스 비활성화 -------------------------"
echo "[_START_]"
echo "[기준]: Finger 서비스가 비활성화 되어 있을 시 양호"
echo "[현황]"
echo " "

echo "Finger 서비스 활성화 여부 확인"
ps -ef | egrep "finger" | grep -v "grep"
echo " "

echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo ""
echo "Finger(사용자 정보 확인서비스)를 통해 네트워크 외부에서 해당 시스템에 등록된 사용자 정보 확인 가능"
echo "Finger 서비스 비활성화 권고"
echo "결과 값이 안나온다면 비활성화 --> 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-20. Anonymous FTP 비활성화 ------------------------"
echo "[_START_]"
echo "[기준]: Anonymous FTP (익명 ftp) 접속을 차단한 경우 양호"
echo "[현황]"
echo " "

echo "## FTP 사용 여부 확인"
ps -ef | grep -i "ftp" | grep -v "grep"
ps -ef | grep -i "inetd" | grep -v "grep"
cat $INETD_CONF | grep "ftpd"
cat $XINETD_CONF | grep "ftpd" 
echo " "

echo "## VSFTP 익명 FTP 연결 확인"
cat /etc/vsftpd/vsftpd.conf | grep "anonymous_enable"
echo " "

echo "## /etc/passwd에 FTP 계정 확인"
cat $PASSWD | grep -i "ftp"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "익명계정에 대한 FTP 접근이 제한(anonymous_enable=NO 또는 주석처리)되어 있으면 양호"
echo "Anonymous FTP 제한을 위해 FTP 계정 삭제 확인"
echo "/etc/vsftpd/vsftpd.conf 파일의 anonymous_enable이 yes로 되어있으면 no로 변경"
echo "결과 값이 안나온다면 비활성화"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-21. r 계열 서비스 비활성화 -------------------------"
echo "[_START_]"
echo "[기준]: 불필요한 r 계열 서비스가 비활성화 되어있거나 결과값이 없을시 양호"
echo "[현황]"
echo " "

echo "## 취약한 r 명령어"
ps -ef | egrep "rsh|rlogin|rexec|rcp"
echo " "

echo "## /etc/(x)inetd.d 에서 rsh, rlogin, rexec, rcp 서비스파일 확인"
cat /etc/xinetd.d | grep "rsh|rlogin|rexec|rcp"
echo " "

echo "## rsh 확인"
cat /etc/inetd.d/rsh | grep -Pw "disable|server"  
cat /etc/xinetd.d/rsh | grep -Pw "disable|server" 
echo " "

echo "rlogin 확인"
cat /etc/inetd.d/rlogin | grep -Pw "disable|server"  
cat /etc/xinetd.d/rlogin | grep -Pw "disable|server" 
echo " "

echo "rexec 확인"
cat /etc/inetd.d/rexec | grep -Pw "disable|server" 
cat /etc/xinetd.d/rexec | grep -Pw "disable|server"
echo " "

echo "rcp 확인"
cat /etc/inetd.d/rcp | grep -Pw "disable|server"  
cat /etc/xinetd.d/rcp | grep -Pw "disable|server"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "## 'r' command는 인증 없이 관리자의 원격접속을 가능하게하는 명령어(rsh, rlogin, rexec, rcp)"
echo "## r서비스가 이용가능할시 중요 정보 유출 및 시스템 장애 발생 등 침해사고 위험이 있어 비활성화 요구"
echo " "
echo "/etc/(x)inetd.d 의 각 서비스파일 설정에 비활성화(disable=yes) 되어있는지 확인"
echo "결과 값이 안나온다면 비활성화 --> 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-22. cron 파일 소유자 및 권한 설정 ------------------"
echo "[_START_]"
echo "[기준]: cron 접근제어 파일 소유자가 root이고, 권한이 640 이하일시 양호"
echo "[현황]"
echo " "

echo "## cron.allow 확인"
ls -aldL $CRON_ALLOW
echo " "

echo "## cron.deny 확인"
ls -aldL $CRON_DENY
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "cron은 특정 시간에, 마다 특정 작업을 자동으로 수행해주는 명령어"
echo "불법적인 예약파일 실행으로 시스템 피해를 일으킬 수 있음"
echo " "
echo "cron.allow와 crom.deny 파일의 권한 under 640(-rw-r-----) 설정 및 소유자 root 설정 권고"
echo "Default로 allow파일은 존재하지 않음 deny파일만 존재"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-23. DOS 공격에 취약한 서비스 비활성화 ---------------"
echo "[_START_]"
echo "[기준]: 사용하지 않는 DoS 공격에 취약한 서비스가 비활성화된 경우 양호"
echo "[현황]"
echo " "

echo "DoS 공격에 취약한 서비스 확인"
ps -ef | egrep "echo|discard|daytime|chargen"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "DoS 공격에 취약한 서비스(echo, discard, daytime, chargen) 비활성화"
echo "결과 값이 안나온다면 비활성화로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-24. NFS 서비스 비활성화 ---------------------------"
echo "[_START_]"
echo "[기준]: 불필요한 NFS 서비스 관련 데몬이 비활성화 되어있을시 양호"
echo "[현황]"
echo " "

echo "NFS 관련 데몬 확인"
ps -ef | grep "nfs"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "## NFS는 사용자가 원격지 PC에 있는 파일을 검색, 저장, 수정하도록 해주는 클라이어트/서버형 응용프로그램"
echo "불필요한 NFS 서비스 비활성화"
echo "결과 값이 안나온다면 비활성화 되어 있는 것이므로 양호"
echo "[_REND_]"
echo " "

echo "-------------------- U-25. NFS 접근통제 ----------------------------------"
echo "[_START_]"
echo "[기준]: 불필요한 NFS 서비스를 사용하지 않거나, 불가피하게 사용 시 everyone 공유를 제한한 경우 양호"
echo "[현황]"
echo " "

echo "## dfstab 점검"
grep -v '^#' /etc/dfs/dfstab
echo " "

echo "## sharetab 점검"
grep -v '^#' /etc/dfs/sharetab
echo " "

echo "## exports 점검 (Linux)"
grep -v '^#' /etc/exports
echo " "

echo "## share 명령어 확인"
share
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "쓰기권한으로 export시키지 않음. 읽기 모드로 사용하여야 하고"
echo "반드시 nfs를 사용해야 할 경우 보안설정(dfstab)에 주의함"
echo "결과 값이 안나온다면 비활성화로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-26. automountd 제거 -------------------------------"
echo "[_START_]"
echo "[기준]: automountd 서비스가 비활성화 되어있을시 양호"
echo "[현황]"
echo " "

echo "## automountd 서비스 데몬 확인"
ps -ef | grep "automountd"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "## automountd란 로컬 공격자가 데몬에 Remote Procedure Call를 보낼수 있는 취약점 존재"
echo "불필요한 automountd 비활성화"
echo "결과 값이 안나온다면 비활성화로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-27. RPC 서비스 확인 -------------------------------"
echo "[_START_]"
echo "[기준]: 불필요한 RPC 서비스가 비활성화 되어있을시 양호"
echo "[현황]"
echo " "

echo "## 취약한 RPC 서비스 확인"
ps -ef | egrep "rpc.cmsd|rusersd|rstatd|rpc.statd|kcms_server|rpc.ttdbserverd|walld|rpc.nids|rpc.ypupdated|cachefsd|sadmind|sprayd|rpc.pcnfsd|rexed|rpc.rquotad" | grep -v "grep"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "취약한 RPC 서비스 제한"
echo "버퍼 오버플로우 취약성으로 root 권한 획득 및 침해사고 발생 위험이 있는 서비스를 중지해야 함"
echo "결과 값이 안나온다면 비활성화로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-28. NIS, NIS+ 점검 --------------------------------"
echo "[_START_]"
echo "[기준]: NIS 서비스가 비활성화 되어있거나, 필요시 NIS+를 사용하는 경우 양호"
echo "[현황]"
echo " "

echo "## NIS, NIS+ 서비스 구동 확인"
ps -ef | egrep $SERVICE | grep -v "grep"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "NIS, NIS+ 사용여부 확인"
echo "보안상 취약하기 때문에 사용을 권고하지 않으나, 사용해야할 경우 보안상 더 양호한 NIS+ 사용 권고"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-29. tftp, talk 서비스 비활성화 ---------------------"
echo "[_START_]"
echo "[기준]: tftp, talk, ntalk 서비스가 비활성화되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## tftp, talk, ntalk 서비스 활성화 여부 확인"
ps -ef | egrep "tftp|talk"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "tftp, talk, ntalk 서비스(불필요 서비스) 비활성화 --> 보안성 높임 --> 서비스 취약점 발견으로 인한 피해 최소화"
echo "결과 값이 안나온다면 비활성화로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-30. Sendmail 버전 점검 ----------------------------"
echo "[_START_]"
echo "[기준]: Sendmail 버전이 최신버전으로 확인되면 양호"
echo "[현황]"
echo " "

echo "## Sendmail 프로세스 확인"
ps -ef | grep -i "sendmail"
echo " "

echo "## Sendmail 버전 정보 확인"
sendmail -d0.1 < /dev/null | grep -i "version"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "최신버전 확인 http://www.sendmail.org"
echo "정기적인 sendmail 버전 점검 및 최신 패치 적용 시 양호"
echo "결과 값이 안나온다면 미설치 또는 비활성화로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-31. 스팸 메일 릴레이 제한 --------------------------"
echo "[_START_]"
echo "[기준]: SMTP 서비스를 사용하지 않거나 릴레이 제한이 설정되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## 스팸 메일 릴레이 설정 확인(Sendmail 8.9이상)"
cat $SMTP_SPAM
echo " "

echo "## Relaying 점검"
cat $SMTP_CONF | grep "R$\*" | grep -i "Relaying"
echo " "

echo "## SMTP 서비스 사용 여부 확인"
ps -ef | grep "sendmail" | grep -v "grep"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "스팸 메일 릴레이 방지 설정 권고"
echo "/etc/mail/sendmail.cf의 R 0error  5.7.1 $: 550 Relaying denied의 주석(#)제거"
echo "릴레이 기능을 제한하지 않을 경우, 스팸 메일 서버로 악용, 서버 부하--> 인증된 사용자에게 메일 보낼수 있도록 설정, 불필요시 중지"
echo "결과 값이 안나온다면 미설치 또는 비활성화로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-32. 일반사용자의 Sendmail 실행 방지 ----------------"
echo "[_START_]"
echo "[기준]: SMTP 서비스 미사용 또는 일반 사용자의 Sendmail 실행 방지가 설정되어 있을 시 양호"
echo "[현황]"
echo " "

echo "## SMTP O PrivacyOptions, restrictqrun 옵션 확인"
cat $SMTP_CONF | grep -i "O PrivacyOptions" | grep -i "restrictqrun" 
echo " "

echo "SMTP 서비스 사용 여부 및 restrictqrun 옵션 확인"
ps -ef | grep "sendmail" | grep -v "grep"
grep -v '^ *#' $SMTP_CONF | grep "PrivacyOptions"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "sendmail 설정파일 내에 O PrivacyOptions=authwarnings,novrfy,noexpn,restrictqrun 설정 권고"
echo "결과 값이 안나온다면 미설치 또는 비활성화"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-33. DNS 보안 버전 패치 ----------------------------"
echo "[_START_]"
echo "[기준]: DNS 서비스를 사용하지 않거나 주기적으로 패치를 관리하고 있다면 양호"
echo "[현황]"
echo " "

echo "## DNS 서비스 사용 확인"
ps -ef | grep "named"
echo " "

echo "## BIND 버전 확인"
named -v
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "양호: DNS 서비스를 사용하지 않거나 주기적으로 패치를 관리하고 있는 경우"
echo "취약: DNS 서비스를 사용하며 주기적으로 패치를 관리하고 있지 않는 경우"
echo " "
echo "결과 값이 안나온다면 미설치 또는 비활성화로 양호"
echo "9.5.0버전 이하의 경우 취약점 존재"
echo "8.3.4 이하버전엔 서비스 공격, 버퍼오버플로우 및 서버 원격 침입 등 취약성 존재"
echo "BIND 8,9 취약점 사이트"
echo "8: https://kb.isc.org/docs/aa-00959"
echo "9: https://kb.isc.org/docs/aa-00913"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-34. DNS Zone Transfer 설정 ------------------------"
echo "[_START_]"
echo "[기준]: DNS 서비스 미사용 또는 Zone Transfer를 허용된 사용자에게만 허용한 경우 양호"
echo "[현황]"
echo " "

echo "## DNS 서비스 사용 여부 점검"
ps -ef | grep "named" | grep -v "grep"
echo " "

echo "## /etc/named.conf 파일의 allow-transfer 및 xfrnets 확인"
echo " "
echo "# allow-transfer 확인"
cat $NAMED_CONF | grep 'allow-transfer'
echo " "

echo "# xfrnets 확인"
cat $NAMED_CONF | grep "xfrnets"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "zone 영역 전송이 특정 호스트로 제한 (allow-transfer { IP; }) 되어 있거나"
echo "options xfrnets IP가 설정되어 있다면 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-35. 웹 서비스 디렉터리 리스팅 제거 --------------------"
echo "[_START_]"
echo "[기준]: 디렉터리 검색 기능을 사용하지 않는 경우 양호"
echo "[현황]"
echo " "

echo "## Indexes 옵션 사용 여부 확인"
cat /etc/httpd/conf/httpd.conf | grep -i "Indexes"
echo " "


echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "## Options 지시자에서 Indexes 옵션 설정 시 취약"
echo "## 미 출력시 옵션 미설정이므로 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-36. 웹 서비스 웹 프로세스 권한 제한 -------------------"
echo "[_START_]"
echo "[기준]: 웹 서비스 데몬이 root 권한으로 구동되지 않을 경우 양호"
echo "[현황]"
echo " "

echo "## 데몬 구동 권한 (User) 확인"
cat /etc/httpd/conf/httpd.conf | grep -i "User"
echo " "


echo "## 데몬 구동 권한 (Group) 확인"
cat /etc/httpd/conf/httpd.conf | grep -i "Group"

echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "## 데몬 User & Group 부분에 root 계정이 아닌 별도 계정으로 설정되어 있을 시 양호"
echo "## 웹 서비스 실행 계정은 로그인 불가능하도록 쉘 제한 설정 필수"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-37. Apache 상위 디렉터리 접근 금지 -----------------"
echo "[_START_]"
echo "[기준]: 상위 디렉터리에 이동제한을 설정한 경우 양호"
echo "[현황]"
echo " "

echo "## Config 파일 점검"
cat /etc/httpd/conf/httpd.conf | grep -i "AllowOverride"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "AllowOverride None으로 확인 시 취약"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-38. 웹 서비스 불필요한 파일 제거 ----------------------"
echo "[_START_]"
echo "[기준]: 기본으로 생성되는 불필요한 파일 및 디렉터리가 제거되어 있는 경우 양호"
echo "[현황]"
echo " "

echo "## 기본 생성 불필요 파일 및 디렉터리 존재 여부 점검"
ls -ld /etc/apache2/htdocs/manual
ls -ld /etc/apache2/manual
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "추가적으로 웹 서비스 운영에 불필요한 파일 및 디렉터리 인터뷰 통해 확인"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-39. 웹 서비스 링크 사용 금지 -------------------------"
echo "[_START_]"
echo "[기준]: 심볼릭 링크, aliases 사용을 제한한 경우 양호"
echo "[현황]"
echo " "

echo "## Config 파일 점검"
cat /etc/httpd/conf/httpd.conf | grep -i "Options"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "Options에 FollowSymLinks 옵션 미확인될 시 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-40. 웹 서비스 파일 업로드 및 다운로드 제한 ------------"
echo "[_START_]"
echo "[기준]: 파일 업로드 및 다운로드를 제한한 경우 양호"
echo "[현황]"
echo " "

echo "## Config 파일 점검"
cat /etc/httpd/conf/httpd.conf | grep -i "LimitRequestBody"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "## LimitRequestBody 지시자에 파일 사이즈 용량 제한 설정되어 있을 시 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-41. 웹 서비스 서비스 영역의 분리 -------------------"
echo "[_START_]"
echo "[기준]: DocumentRoot를 별도의 디렉터리로 지정한 경우 양호"
echo "[현황]"
echo " "

echo "## Config 파일 점검"
cat /etc/httpd/conf/httpd.conf | grep -i "DocumentRoot"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "/usr/local/apache/htdocs 또는 /usr/local/apache2/htdocs 또는 /var/www/html로 지정되어 있으면 양호"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-60. SSH 원격 접속 허용 ----------------------------"
echo "[_START_]"
echo "[기준]: 원격 접속 시 SSH 프로토콜을 사용하는 경우 양호"
echo "[현황]"
echo " "

echo "## SSH 포트 확인"
netstat -na | grep 22
echo " "

echo "## SSH 프로세스 확인"
ps -ef  | grep "sshd"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "SSH를 이용하여 원격 접속이 이루어지는 지 확인"
echo "Telnet 사용시 취약"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-61. FTP 서비스 확인 -------------------------------"
echo "[_START_]"
echo "[기준]: FTP 서비스가 비활성화 되어 있는 경우 양호"
echo "[현황]"
echo " "

echo "## FTP 서비스 실행 여부 확인"
ps -ef | grep ftp | grep -v 'grep'
echo " "
ps -ef | egrep "vsftpd|proftp"

echo "## (X)INETD 방식 FTP 서비스 확인"
ps -ef | grep inetd | grep -v "grep"
echo " "

echo "* FTP 활성화 여부 확인"       
cat $INETD_CONF | grep -i "ftp"      
echo " "
cat $XINETD_CONF | grep -i "ftp"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "FTP 서비스 비활성화, 사용해야 한다면 암호화 통신이 되는 접속 프로토콜 사용시 양호"
echo "반드시 필요한 경우를 제외하고는 사용 제한을 권고"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-62. FTP 계정 shell 제한 ---------------------------"
echo "[_START_]"
echo "[기준]:  ftp 계정에 /bin/false 쉘이 부여되어 있는 경우 양호"
echo "[현황]"
echo " "

echo "## /etc/passwd 파일 점검"
cat $PASSWD | grep -i ftp
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "FTP 설치시 default ftp 계정은 로그인이 필요하지 않으므로 쉘을 제한하여 시스템 접근 차단 필요"
echo "로그인이 불필요한 default 계정에 쉘을 부여할 경우 공격자에게 해당 계정이 노출, 시스템 불법 침투 가능"
echo "/bin/false 접근 금지"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-63. Ftpusers 파일 소유자 및 권한 설정 --------------"
echo "[_START_]"
echo "[기준]: ftpusers 파일의 소유자가 root이고, 권한이 640 이하인 경우 양호"
echo "[현황]"
echo " "

echo "## ftpusers 파일 점검"
ls -al /etc/ftpusers
echo " "

ls -al /etc/ftpd/ftpusers
echo " "

ls -al /etc/vsftpd/ftpusers  
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo " 소유자: root, -rw-r----- under 640 권고"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-64. Ftpusers 파일 설정 ----------------------------"
echo "[_START_]"
echo "[기준]: FTP 서비스가 비활성화 되어있거나, 활성화시 root 계정 접속을 차단한 경우 양호"
echo "[현황]"
echo " "

echo "## /etc/ftpusers 점검"
cat /etc/ftpusers
echo " "

echo "## /etc/ftpd/ftpusers 점검"
cat /etc/ftpd/ftpusers
echo " "

echo "## ProFTP 점검"
cat /etc/proftpd.conf
echo " "

echo "## vsFTP 점검"
echo " "
echo "/etc/vsftpd/ftpusers 점검"
cat /etc/vsftpd/ftpusers
echo " "
echo "/etc/vsftpd/user_list 점검"
cat /etc/vsftpd/user_list
echo " "
echo "/etc/vsftpd/ftpusers 점검"
cat /etc/vsftpd/ftpusers
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "1. ftpusers 파일내에 #root (주석처리) 또는 root 계정 미등록"
echo "2. ProFTP 파일내에 RootLogin off"
echo "3. vsFTP 파일내에 #root (주석처리) 또는 root 계정 미등록"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-65. at 파일 소유자 및 권한 설정 --------------------"
echo "[_START_]"
echo "[기준]: at 접근제어 파일의 소유자가 root이고, 권한이 640 이하 설정시 양호"
echo "[현황]"
echo " "

echo "## at 파일 소유지 및 권한 점검 (Allow)"
ls -aldL $AT_ALLOW
echo " "

echo "## at 파일 소유자 및 권한 점검(deny)"
ls -aldL $AT_DENY
echo " "

echo "## at.allow 점검"
cat $AT_ALLOW
echo " "

echo "## at.deny 점검"
cat $AT_DENY
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "at 데몬은 지정한 시간에 특정 작업이 실행될 수 있도록 작업 스케줄을 예약 처리해주는 기능 제공"
echo "/etc/at.allow 파일에 등록된 사용자만이 at명령을 사용할 수 있음"
echo "at 파일의 소유자: root | 권한: -rw-r----- under 640"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-66. SNMP 서비스 구동 점검 -------------------------"
echo "[_START_]"
echo "[기준]: SNMP 서비스를 사용하지 않는 경우 양호"
echo "[현황]"
echo " "

echo "## SNMP 사용여부 확인 - ps 명령"
ps -ef | grep snmp | grep -v 'grep'
echo " "

echo "## SNMP 사용여부 확인 - netstat 명령"
netstat -an | egrep ':161|.161'
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "양호: SNMP 서비스를 사용하지 않는 경우 or 서비스를 사용하지만 U-67 항목이 양호인 경우"
echo "취약: SNMP 서비스를 사용하고 and U-67 항목이 취약인 경우"
echo " "
echo "[_REND_]"
echo " "

echo "--------------- U-67. SNMP 서비스 커뮤니티 스트링의 복잡성 설정 -------------"
echo "[_START_]"
echo "[기준]: SNMP Community 이름이 public, private이 아닌 경우 양호"
echo "[현황]"
echo " "

echo "## snmpd.conf 파일에서 community 점검"    
cat $SNMP_CONF | grep -i 'community'
echo " "

echo "## /etc/snmpd.conf에서 com2sec notConfigUser 점검"
cat $SNMP_CONF | grep -i 'com2sec' | grep -i 'notConfigUser'
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "Community String은 default로 public, private로 설정된 경우가 다수"
echo "이를 변경하지 않으면 이 String을 악용하여 시스템의 주요 정보 및 설정을 파악할 수 있음"
echo "SNMP의 community name이 기본값인 public, private가 아니도록 설정"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-68. 로그온 시 경고 메시지 제공 ---------------------"
echo "[_START_]"
echo "[기준]: 서버 및 Telnet, FTP, SMTP, DNS, 서비스에 로그온 메시지가 설정되어 있으면 양호"
echo "[현황]"
echo " "

echo "## 서버 로그온 메시지 설정 점검"
cat /etc/motd | grep -v '#'
echo " "

echo "## Telnet 배너 설정 점검"
cat $TELNET_BANNER | grep -i 'herald' | grep -v '#'
echo " "

echo "# /etc/issue 전체 점검"
cat $TELNET_BANNER
echo " "

echo "# /etc/issue.net 점검"
cat /etc/issue.net
echo " "

echo "## FTP 배너 설정 점검"
cat $FTP_BANNER | grep -v '#'
echo " "

echo "# vsftpd.conf 점검"
cat /etc/vsftpd/vsftpd.conf
echo " "

echo "## SMTP 배너 설정 점검"
cat $SMTP_CONF
echo " "

echo "## DNS 배너 설정 점검"
cat $NAMED_CONF
echo " "

echo "## /etc/welcome.msg, vsftpd.msg 메시지 점검"
cat /etc/welcome.msg
echo " "
cat /etc/vsftpd/vsftpd.msg | grep -i "ftpd_banners"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "FTP 접속 경고 배너 수동 점검 : 접속 시도"
echo "로그인 전후 'Authorized users only. All activity may be monitored and reported'와 같은 경고문 띄움"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-69. NFS 설정 파일 접근 권한 ------------------------"
echo "[_START_]"
echo "[기준]: NFS 접근제어 설정 파일의 소유자가 root 이고, 권한이 644 이하인 경우 양호"
echo "[현황]"
echo " "

echo "## NFS 프로세스 확인"
lssrc -g nfs
echo " "

echo "## /etc/exports 점검"
grep -v '^#' /etc/exports
echo " "

echo "## share 명령어 확인"
share
echo " "

echo "## exportfs -a 명령어 확인"
exportfs -a
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "NFS 파일의 소유자: root | 권한: -rw-r--r-- under 644"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-70. expn, vrfy 명령어 제한 ------------------------"
echo "[_START_]"
echo "[기준]: SMTP 서비스 미사용 또는 noexpn, novrfy 옵션이 설정되어 있는 경우 양호"
echo "[현황]"
echo " "

echo "## EXPN, VRFY 명령어 제한 확인"
cat $SMTP_CONF | grep -i "O PrivacyOptions" | grep -i "goaway"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "O PrivacyOptions=authwarnings, noexpn, novrfy 옵션 설정 확인"
echo "EXPN : 메일 전송 시 포워딩하기 위한 명령어"
echo "VRFY : SMTP 클라이언트가 SMTP서버에 특정 ID에 대한 메일이 있는지 검증하기 위한 명령어"
echo " "
echo "[_REND_]"
echo " "

echo "------------------ U-71. 웹 서비스 서비스 정보 숨김 --------------------------"
echo "[_START_]"
echo "[기준]: ServerTokens Prod, ServerSignatue OFF로 설정되어 있는 경우 양호"
echo "[현황]"
echo " "

echo "ServerTokens, ServerSignature 옵션 확인"

cat /etc/httpd/conf/httpd.conf | grep -i "ServerTokens"
echo " "
echo " "

cat /etc/httpd/conf/httpd.conf | grep -i "ServerSignature"
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "ServerTokens 지시자에 Prod 옵션, ServerSignature 지시자에 Off 옵션 확인될 시 양호"
echo " "
echo "[_REND_]"
echo " "

echo "******************************** 4. 패치 관리 ******************************"
echo " "

echo "------------------ U-42. 최신 보안패치 및 벤더 권고사항 적용 ----------------"
echo "[_START_]"
echo "[기준]: 패치 적용 정책을 수립하여 주기적으로 패치관리를 하고 있으며, 패치 관련 내용을 확인하고 적용했을 경우 양호"
echo "[현황]"
echo " "

echo "## 커널 정보 확인"
cat /proc/version
echo " "

echo "## OS버전 정보 확인"
uname -a
echo " "

echo "## OS 버전 정보 확인_2"
cat /etc/issue
echo " "

echo "## OS 버전 정보 확인_3"
cat /etc/*release*
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "Redhat 보안 사이트"
echo "http://www.redhat.com/security/updates/"
echo " "
echo "[_REND_]"
echo " "

echo "******************************** 5. 로그 관리 ******************************"
echo " "

echo "-------------------- U-43. 로그의 정기적 검토 및 보고 ---------------------"
echo "[_START_]"
echo "[기준]: 접속기록 등의 보안 로그, 응용 프로그램 및 시스템 로그 기록에 대해 정기적으로 검토, 분석, 리포트 작성 및 보고 등의 조치가 이루어지는 경우 양호"
echo "[현황]"
echo " "

echo "## /etc/syslog.conf 점검"
if [ -e /etc/syslog.conf ]; then
	cat /etc/syslog.conf | grep -v "#"
fi
echo " "

echo "## rsyslog.conf 점검"
if [ -e /etc/rsyslog.conf ]; then
	cat /etc/rsyslog.conf | grep -v "#"
fi
echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "/etc/syslog.conf 다음의 설정을 권고함"
echo "mail.debug/var/adm/syslog/mail.log"
echo "*.info/var/adm/syslog/syslog.log"
echo "*.alert/var/adm/syslog/syslog.log"
echo "*.alert/dev/console"
echo "*.alertroot"
echo "*.emerg*"
echo " "
echo "정기적으로 로그 분석에 대한 결과물 존재 확인"
echo "다음 스크립트 결과는 추가적으로 확인"
echo " "
echo "[_REND_]"
echo " "

echo "-------------------- U-72. 정책에 따른 시스템 로깅 설정 -------------------"
echo "[_START_]"
echo "[기준]: 로그 기록 정책이 정책에 따라 설정되어 수립되어 있으며 보안정책에 따라 로그를 남기고 있을 시 양호"
echo "[현황]"
echo " "

echo "## syslog 파일 탐색"
cat $SYSLOG_CONF | grep -v '^#'
echo " "

echo "## rsyslog 파일 탐색"
cat /etc/rsyslog.conf | grep -v '^#'
echo " "

echo "## syslog 파일 내 로깅 설정 확인"

echo " "

echo "-----------------------------------------------"
echo " "

echo "## rsyslog 파일 내 로깅 설정 확인"

echo " "
echo " "
echo "[_END_]"
echo " "
echo " "

echo "[_RSTART_]"
echo " "
echo "정책에 따른 시스템 로깅 설정 담당자 인터뷰 확인"
echo " "
echo "[_REND_]"
echo " "

echo "* System Information Query End"
echo " "

echo " ** End Time "
date

echo "** K10ud_ShineMusket **"
exit 0
