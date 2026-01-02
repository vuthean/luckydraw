 
 
PROJECT_NAME="lucky-draw"
PROJECT_LANG="php-luckydraw"
TELEGRAM_URL="http://10.80.80.146:1000/bot"
CHAT_ID="-1001518662516"
ARGO_PROJECTNAME="portal"
SVC_TYPE="dap"

CI_COMMIT_BRANCH='kubernetes-dev'
CI_PIPELINE_ID="123"
FINAL_PROJECT_NAME="lucky-draw:123"
REG_URL='10.80.80.148:5000'
docker-builder build-ci -b $CI_COMMIT_BRANCH -z $CI_PIPELINE_ID -l $PROJECT_LANG -p $(pwd) -x $FINAL_PROJECT_NAME -j $JDK_VERSION -n prince -w $PW --reg_url $REG_URL