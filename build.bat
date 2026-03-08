cd frontend
ng build --configuration production
cd ..
if exist "out" (
    rmdir /s /q "out"
)
mkdir out
mkdir out\data
xcopy /s /i "frontend\dist\istperegrination\browser" "out\data\frontend"
xcopy /s /i "backend\*" "out\data\"
copy ".htaccess" "out\data\.htaccess"
copy "compose.prod.yml" "out\compose.yml"
if exist ".env.prod" (
    copy ".env.prod" "out\.env"
) else (
    echo [WARNING] .env.prod not found. Please create one based on .env.example and place it in the project root.
)
