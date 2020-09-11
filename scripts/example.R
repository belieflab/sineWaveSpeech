
# Title: Mooney Faces Task Cleaning & Scoring Script
# Author: Trevor Williams (trevor.williams@northwestern.edu)



# STOP! If you did not open this as a project, do so NOW.
### (1) Open new project, select the Mooney Faces folder, click "open"
### (2) Open this script from the script folder



# Load necessary packages
### need tidyverse, install.packages(tidyverse) if not already installed
### if tidyverse install fails, first install.packages(httr) and try again

library(tidyverse)


# Searches directory for all data files
### Note: won't work unless using R project open to "mooneyFaces" folder
file_list <- list.files(path=paste0(getwd(), '/data'), pattern = ".csv$")


# Imports and scores data
ld <- data.frame()
for (i in 1:length(file_list)){
  ### reads each individual data file
  temp_data <- read.csv(paste0(getwd(), '/data/',file_list[i]))   
  ### creates participant ID
  temp_data$ID <- sapply(strsplit(gsub(".csv", "", file_list[i]), "_"), 
                         function(x){x[2]}) 
  ### creates initial variables
  temp_data$o_corr <- ifelse(temp_data$test_part=="original",
                             ifelse(temp_data$correct=="true",1,0),0)
  temp_data$i_corr <- ifelse(temp_data$test_part=="inverted",
                             ifelse(temp_data$correct=="true",1,0),0)
  temp_data$o_err <- ifelse(temp_data$test_part=="original",
                            ifelse(temp_data$correct=="false",1,0),0)
  temp_data$i_err <- ifelse(temp_data$test_part=="inverted",
                            ifelse(temp_data$correct=="false",1,0),0)
  ### creates scored variables
  temp_data$orig_corr_tot <- sum(temp_data$o_corr)
  temp_data$invt_corr_tot <- sum(temp_data$i_corr)
  temp_data$orig_err_tot <- sum(temp_data$o_err)
  temp_data$invt_err_tot <- sum(temp_data$i_err)
  temp_data$orig_corr_pct <- round((sum(temp_data$o_corr)/43)*100,digits = 2)
  temp_data$invt_corr_pct <- round((sum(temp_data$i_corr)/43)*100,digits = 2)
### for each iteration, binds the new data to the main dataset
ld <- rbind(ld, temp_data) 
}


# Basic data cleaning
  ### creates stimulus ID
  ld$string <- gsub(".jpg","",ld$stimulus) 
  ld$stimid <- substring(ld$string,regexpr("bitmap",ld$string)+6)
  ### remove unnecessary rows and columns
  ld$test_part[ld$test_part==''] <- NA
  ld$remove <- ifelse(is.na(ld$test_part),1,ifelse(ld$test_part=="fixation",1,0))
  drops1 <- c("ld$key_press","trial_type","time_elapse",
            "internal_node_id","correct_response","correct",
            "o_corr","i_corr","o_err","i_err","remove","stimulus","key_press",
            "trial_index","test_part","time_elapsed","string")
  drops2 <- c("ld$key_press","trial_type","time_elapse",
           "internal_node_id","correct",
           "o_corr","i_corr","o_err","i_err","remove","stimulus","key_press",
           "trial_index","test_part","time_elapsed","string")
  clean <- ld[ld$remove==0,!(names(ld) %in% drops1)]
  clean2 <- ld[ld$remove==0,!(names(ld) %in% drops2)]

  
# creates long dataset  
  ### fixes reaction time
  clean2$rt <- as.numeric(clean2$rt)
  clean2$rt <- round(clean2$rt,digits=2)
  ### sorts by ID and stimid
  clean2$stimid[clean2$stimid=="46.3.1"] <- "46.31"
  clean2$ID <- as.numeric(clean2$ID)
  clean2$stimid <- as.numeric(clean2$stimid)
  sorted2 <- clean2[order(clean2$ID,clean2$stimid),]
  ### reorders
  long <- sorted2[,c(4,11,1,3,2,5,6,7,8,9,10)]
  
  
# creates wide dataset
  ### fixes reaction time
  clean$rt <- as.numeric(clean$rt)
  clean$rt <- round(clean$rt,digits=2)
  ### sorts by ID and stimid
  clean$stimid[clean$stimid=="46.3.1"] <- "46.31"
  clean$ID <- as.numeric(clean$ID)
  clean$stimid <- as.numeric(clean$stimid)
  sorted <- clean[order(clean$ID,clean$stimid),]
  ### converts to wide
  names <- c("ID", "orig_corr_tot", "invt_corr_tot","orig_err_tot",
  "invt_err_tot", "orig_corr_pct", "invt_corr_pct")
  wide <-reshape(sorted,timevar="stimid",idvar=names,direction = "wide")
 
  
# writes out processed files for export folder
### creates unique file name based on time & date in "UTC"
  write.csv(wide, file = paste0(getwd(),'/output/mooney_data_wide_',
            gsub(":",".",lubridate::with_tz(Sys.time(), "UTC")),".csv"))
  
  write.csv(long, file = paste0(getwd(),'/output/mooney_data_long_',
            gsub(":",".",lubridate::with_tz(Sys.time(), "UTC")),".csv"))
  
  
  
  