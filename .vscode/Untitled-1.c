#include<stdio.h>
#include<string.h>
#include<conio.h>
#include <stdbool.h>
struct Login
{
    char fname[100];
    char lname[100];
    char username[50];
    char pass[100];
};
struct Vaccin{
    char hospital[200];
    char contactNum[200];
};
signup(){
    FILE *log;
    log = fopen("userinfo.txt", "a");
    struct Login login;
    printf("Enter First Name : ");
    scanf("%s", login.fname);
    printf("Enter Last Name : ");
    scanf("%s", login.lname);
    printf("Enter User Name : ");
    scanf("%s", login.username);
    printf("Enter Password : ");
    scanf("%s", login.pass);
    fprintf(log,"%s %s %s %s\n",  login.fname, login.lname, login.username, login.pass);
    fclose(log);
    printf("\n\nYour Registration is successful\n");
    printf("Press Any Key to Continue.....");
    getch();
    system("CLS");
}

login(){

    char username[50], pass[100];
    struct Login login;
    FILE *log;

    log = fopen("userinfo.txt", "r");

    if (log == NULL){
        printf("Error at opening File!");
    }

    printf("User ID : ");
    scanf("%s", username);
    printf("Password : ");
    scanf("%s", pass);

    bool isLoggedIn = false;

    while(fscanf(log, "%s %s %s %s", login.fname, login.lname, login.username, login.pass)!=EOF){

        if(strcmp(username, login.username)==0 && strcmp(pass, login.pass)==0){
            isLoggedIn = true;
            break;
        }

    }

    if(isLoggedIn){
        printf("Congratulations You Have Loggedin Successfully!\n Press any key to continue!\n");
        getch();
        division();

    }else{
        printf("Please Enter Correct User Name And Password! Press any key to continue!\n");
        getch();
    }

    fclose(log);
    system("CLS");
}

main(){

    int choice;

    while(true){
        printf("Press '1' for Signup\nPress '2' for Login\nPress '3' to exit\n");
        scanf("%d",&choice);
        if(choice==1){
            system("CLS");
            signup();
        }else if (choice==2){
            system("CLS");
            login();
        }else if(choice==3){
            system("CLS");
            break;
        }else{
            system("CLS");
            printf("Wrong input! Try again!\n");
        }
    }

}
int division()
{
 int num;
    printf(" 1.Dhaka");
    printf("\n 2.Sylhet");
    printf("\n 3.Mymensingh");
    printf("\n 4.Rajshahi");
    printf("\n 5.Chittagong");
    printf("\n 6.Barishal");
    printf("\n 7.Khulna");
    printf("\n 8.Rangpur\n");
    printf("Enter your choice : ");
    scanf("%d",&num);

    switch(num)
    {
    case 1:
        printf("\nDhaka ");
        break;
    case 2:
          printf("\nSylhet ");
        break;
    case 3:
         printf("\nMymensingh");
        break;
    case 4:
        printf("\nRajshahi ");
        case 5:
        printf("\nChittagong ");
        break;
    case 6:
          printf("\nBarishal ");
        break;
    case 7:
         printf("\nKhulna");
        break;
    case 8:
        printf("\nRangpur ");


        break;
    }

{
 int ch;
    printf("\n 1.Available oxygen supplies");
    printf("\n 2.Available icu beds");
    printf("\n 3.Available Corona treatments giving hospitals");
    printf("\n 4.Available vaccine giving hospitals\n");

    printf("Enter your choice : ");
    scanf("%d",&ch);

    switch(ch)
    {
    case 1:
        printf("\n Available oxygen supplies");
        { int b;

        printf("\n1.High Nasal\n");
        printf("\n2.Normal flow\n");
        printf("Enter your choice : ");
         scanf("%d",&b);
           {

            switch (b)
            {
           case 1:
            printf("High nasal flows are : ");

            break;
            case 2:
            printf("Normal nasal flows are : ");
            break;
            }}
        }
        break;
    case 2:
          printf("\n Available icu beds");
        break;
    case 3:
         printf("\n Available Corona treatments giving hospitals");
        break;
    case 4:
        printf("\n Available vaccine giving hospitals\n");
        vaccine();

       // break;
    }

}

}
int vaccine(){

    int i=0,n=0;
    struct Vaccin vaccin[10];
    char c[200];

    FILE *f;
    f = fopen("Store.txt", "r");

    while(!feof(f)){
        fgets(c,200,f);
        strcpy(vaccin[i].hospital,c);
        fgets(c,200,f);
        strcpy(vaccin[i].contactNum,c);
        i++;
    }
    n=i;

    for(i=0;i<n;i++){
        puts(vaccin[i].hospital);
        puts(vaccin[i].contactNum);
    }

    fclose(f);




    return 0;
}


