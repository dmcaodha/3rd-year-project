package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import java.util.ArrayList;
import java.util.List;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class QuestionXMLHandler extends DefaultHandler {
	
	private List<Question> myQuestions;
	private Question currentQuestion;
	private List<String> myPossAnswers;
	private boolean inQuestions;
	private boolean inQuestion;
	private boolean inQuestText;
	private boolean inType;
	private boolean inPosition;
	private boolean inPossAnswers;
	private boolean inChoice1;
	private boolean inChoice2;
	private boolean inChoice3;
	private boolean inChoice4;
	private boolean inChoice5;

	// Method called when parser reads the beginning of an xml file
	public void startDocument() throws SAXException {
		this.myQuestions = new ArrayList<Question>();
		this.currentQuestion = null;
		this.inQuestions = false;
		this.inQuestion = false;
		this.inQuestText = false;
		this.inType = false;
		this.inPosition = false;
		this.inPossAnswers = false;
		this.inChoice1 = false;
		this.inChoice2 = false;
		this.inChoice3 = false;
		this.inChoice4 = false;
		this.inChoice5 = false;
	}

	public void endDocument() throws SAXException {
		// TODO Auto-generated method stub
		
	}
	// Method called when parser reads the beginning of an element tag in XML
	public void startElement(String uri, String localName, String qName,
			Attributes atts) throws SAXException {
		if (localName.equalsIgnoreCase("questions")) inQuestions = true;
		else if (localName.equalsIgnoreCase("question")) {
			inQuestion = true;
			currentQuestion = new Question();
			currentQuestion.id = Integer.parseInt(atts.getValue("id"));
		}
		else if (localName.equalsIgnoreCase("questtext")) inQuestText = true;
		else if (localName.equalsIgnoreCase("type")) inType = true;
		else if (localName.equalsIgnoreCase("position")) inPosition = true;
		else if (localName.equalsIgnoreCase("possanswers")) {
			inPossAnswers = true;
			this.myPossAnswers = new ArrayList<String>();
		}
		else if (localName.equalsIgnoreCase("choice1")) inChoice1 = true;
		else if (localName.equalsIgnoreCase("choice2")) inChoice2 = true;
		else if (localName.equalsIgnoreCase("choice3")) inChoice3 = true;
		else if (localName.equalsIgnoreCase("choice4")) inChoice4 = true;
		else if (localName.equalsIgnoreCase("choice5")) inChoice5 = true;
		
	}
	// Method called when parser reads the end of an element tag in XML
	public void endElement(String uri, String localName, String qName)
			throws SAXException {
		if (localName.equalsIgnoreCase("questions")) inQuestions = false;
		else if (localName.equalsIgnoreCase("question")) {
			inQuestion = false;
			myQuestions.add(currentQuestion);
			currentQuestion = null;
		}
		else if (localName.equalsIgnoreCase("questtext")) inQuestText = false;
		else if (localName.equalsIgnoreCase("type")) inType = false;
		else if (localName.equalsIgnoreCase("position")) inPosition = false;
		else if (localName.equalsIgnoreCase("possanswers")) {
			inPossAnswers = false;
			currentQuestion.possAnswers = myPossAnswers;
			myPossAnswers = null;
		}
		else if (localName.equalsIgnoreCase("choice1")) inChoice1 = false;
		else if (localName.equalsIgnoreCase("choice2")) inChoice2 = false;
		else if (localName.equalsIgnoreCase("choice3")) inChoice3 = false;
		else if (localName.equalsIgnoreCase("choice4")) inChoice4 = false;
		else if (localName.equalsIgnoreCase("choice5")) inChoice5 = false;
	}
	// Method called when parser reads the contents of an element tag in XML
	public void characters(char[] ch, int start, int length)
			throws SAXException {
		String content = new String(ch, start, length);
		if (inQuestText) currentQuestion.questText = content;
		else if (inType) currentQuestion.type = content;
		else if (inPosition) currentQuestion.position = Integer.parseInt(content);
		else if (inChoice1) myPossAnswers.add(content);
		else if (inChoice2) myPossAnswers.add(content);
		else if (inChoice3) myPossAnswers.add(content);
		else if (inChoice4) myPossAnswers.add(content);
		else if (inChoice5) myPossAnswers.add(content);
	}
	// Method used to return result
	public List<Question> getQuestionList() {
		return this.myQuestions;
	}
}

