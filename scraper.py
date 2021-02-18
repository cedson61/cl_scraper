from bs4 import BeautifulSoup
import requests
import re
import sys
import os


query = 'search/cto?query=tesla+model+3+long+range&purveyor-input=owner&min_price=25000&max_price=35000&min_auto_miles=1000&max_auto_miles=45000&auto_title_status=1'


url_list = open('out.txt', 'r')
outfile = open('output.txt', 'w')

count = 0

while True:
	count += 1


	url = url_list.readline()
	without_line_breaks = url.replace("\n", "")

	#print (without_line_breaks + '.org/' + query)

	if not url:
		break

	page = requests.get(without_line_breaks + '.org/' + query)

	soup = BeautifulSoup(page.content, 'html.parser')
	for a in soup.find_all('a', attrs={'class': 'result-title'}):
		listingurl = a.attrs['href']
		outfile.write(listingurl + '\n')
		print (listingurl)



url_list.close()
outfile.close()


#cleans shit up
lines_seen = set()  # holds lines already seen
outputfile = open('cleanedoutput.txt', "w")
infile = open('output.txt', "r")
print ("cleaning output...")
for line in infile:
    #print (line)
	if line not in lines_seen:  # not a duplicate
		outputfile.write(line)
		lines_seen.add(line)
outputfile.close()
infile.close()



url_listings_list = open('cleanedoutput.txt', 'r')

count = 0
outfile = open('final.txt', 'w')


while True:
	count += 1
	listingurl = url_listings_list.readline()
	without_line_breaks = listingurl.replace("\n", "")

	if not listingurl:
		break


	page = requests.get(without_line_breaks)
	soup = BeautifulSoup(page.content, 'html.parser')
	title = soup.find("span", {"id": "titletextonly"}).getText()
	title = title.replace(",", "")

	price = soup.find("span", {"class": "price"}).getText()
	price = price.replace(",", "")

	body = soup.get_text()
	
	outfile.write(listingurl)

	outfile.seek(outfile.tell() - 1, os.SEEK_SET)
	outfile.write('')
	
	outfile.write("," + title + "," + price + ",")


	images = soup.findAll('img')
	for image in images:
		outfile.write(image['src'] + "|"),

	outfile.seek(outfile.tell() - 1, os.SEEK_SET)
	outfile.write('')
	outfile.write('\n')

outfile.close()











































    